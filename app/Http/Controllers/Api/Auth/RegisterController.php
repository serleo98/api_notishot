<?php

namespace App\Http\Controllers\Api\Auth;

use App\Core\Controller\BaseController;
use App\Entities\Client\Client;
use App\Entities\Core\Subsidiary;
use App\Entities\User\Role;
use App\Entities\User\User;
use App\Http\Resources\Responses\AssociateClientResource;
use App\Http\Resources\Responses\LoginClientResource;
use App\Http\Resources\Responses\RegisterResource;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;

class RegisterController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('auth:api')->except('register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'subsidiary_id' => ['required', 'integer', Rule::exists('subsidiaries', 'id')],
            'document_type_id' => ['required', 'integer', Rule::exists('document_types', 'id')],
            'document' => ['required', 'string', 'max:50'],
            'client_number' => ['required', 'integer', Rule::exists('clients', 'code')],
        ]);
    }

    protected function validClient(Client $client, array $data, $association = false)
    {
        if (is_null($client)) {
            return false;
        }

        if ($client->document != $data['document']) {
            return false;
        }

        if ($client->document_type_id != $data['document_type_id']) {
            return false;
        }

        // si se está validando para asociar cliente a usuario, no valido sucursal
        if (!$association && $client->subsidiary_id != $data['subsidiary_id']) {
            return false;
        }

        return true;
    }

    protected function userExist(Client $client, array $data)
    {
        return !is_null($client->user()->first());
    }

    protected function clientAssociated(Client $client)
    {
        return !is_null($client->user_id);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Entities\User\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => Role::isRole(Role::getClientKey())->first()->id,
        ]);
    }

    protected function assignUser(Client $client, User $user)
    {
        $client->user_id = $user->id;

        return $client->save();
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $client = Client::number($request->get('client_number'))->connected()->first();

        if (is_null($client) || !$this->validClient($client, $request->all())) {
            return $this->errorBadRequest('Los datos del cliente no concuerdan con nuestros registros.');
        }

        if ($this->userExist($client, $request->all())) {
            return $this->errorBadRequest('Cliente ya se encuentra registrado!');
        }

        event(new Registered($user = $this->create($request->all())));

        $this->assignUser($client, $user);

        return $this->registered($request, $user);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $this->guard()->login($user);

        $tokenResult = $user->createToken('Personal Access Token');
        $tokenResult->token->save();

        return $this->respondWithItem($tokenResult, RegisterResource::class);
    }

    public function associateClient(Request $request)
    {
        $user = auth()->user();

        Validator::make($request->all(), [
            'document_type_id' => ['required', 'integer', Rule::exists('document_types', 'id')],
            'document' => ['required', 'string', 'max:50'],
            'client_number' => ['required', 'integer', Rule::exists('clients', 'code')],
        ])->validate();

        $client = Client::number($request->get('client_number'))->connected()->first();

        if (is_null($client) || !$this->validClient($client, $request->all(), true)) {
            return $this->errorBadRequest('Los datos del cliente no concuerdan con nuestros registros.');
        }

        if ($this->clientAssociated($client)) {
            return $this->errorBadRequest('Cliente ya se encuentra asociado a un usuario!');
        }


        $this->assignUser($client, $user);

        return $this->respondWithItem($user, AssociateClientResource::class);
    }


}