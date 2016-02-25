<?php

use App\Jobs\CreateAPIHelpJob;
use Illuminate\Database\Seeder;

class HelperTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Login Api
         */
        dispatch(new CreateAPIHelpJob([
            'route'          => 'api.user.login',
            'description'    => 'Log the user in the system and returns a unique token',
            'parameters'     => json_encode([
                'credential' => 'Required - Username or Email',
                'password'   => 'Required - User Password'
            ]),
            'response'       => json_encode([
                "username"   => "test",
                "email"      => "test@email.com",
                "gender"     => 'male',
                "country_id" => "30",
                "age_id"     => 1,
                "api_token"  => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
                "newsletter" => "0"
            ]),
            'response_error' => json_encode(['error'      => 'invalid_username_or_password',
                                             "credential" => ["The credential field is required."],
                                             "password"   => ["The password field is required."]
            ])
        ]));

        /**
         * Register Api
         */
        dispatch(new CreateAPIHelpJob([
            'route'          => 'api.user.register',
            'description'    => 'Register a new User into the database',
            'parameters'     => json_encode([
                'username'              => 'Required - Unique Username',
                'email'                 => 'Required - User Email',
                'password'              => 'Required - User Password',
                'password_confirmation' => 'Required - Password Confirmation',
                'terms'                 => 'Required - Accept the terms and conditions of usage',
                'gender'                => 'User Gender Male or Female',
                'country_id'            => 'Country id as on Country Api',
                'newsletter'            => 'Accept to Receive newsletter',
                'age_id'                => 'Age ID',
            ]),
            'response'       => json_encode([
                "username"   => "test",
                "email"      => "test@email.com",
                "gender"     => null,
                "country_id" => "30",
                "age_id"     => 2,
                "api_token"  => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
                "newsletter" => "0"
            ]),
            'response_error' => json_encode(
                [
                    "error" =>
                        [
                            "username" => ["The username field is required."],
                            "email"    => ["The email field is required. | The email has already been taken."],
                            "password" => ["The password field is required."],
                            "terms"    => ["The terms field is required."]
                        ]
                ])

        ]));

        /**
         * Products Api
         */
        dispatch(new CreateAPIHelpJob([
            'route'          => 'api.product.index',
            'description'    => 'Return list with all available products',
            'parameters'     => json_encode([
                'api_token' => 'Required - User Token',
            ]),
            'response'       => json_encode([
                ["id" => 1, "code" => "MF001", "name" => "Batman Stand Version I"],
                ["id" => 2, "code" => "MF002", "name" => "Superman Stand Version I"],
                ["id" => 3, "code" => "MF003", "name" => "Worderwoman Stand Version I"]
            ]),
            'response_error' => json_encode(
                [
                    [
                        "error" => "token_not_provided"
                    ],
                    [
                        "error" => "invalid_token"
                    ]
                ]
            )

        ]));

        /**
         * Single Product Show
         */
        dispatch(new CreateAPIHelpJob([
            'route'          => 'api.product.show',
//            'route_parameters' => json_encode(['product' => 'MF001']),
            'description'    => 'Return information about an specific product',
            'parameters'     => json_encode([
                'api_token'    => 'Required - User Token',
                'product_id'   => 'Required - Product Code or ID',
                'encode_image' => 'Optional - Determine whether retrieve image as a link or as Base64'
            ]),
            'response'       => json_encode([
                    "id"    => 1,
                    "name"  => "Batman Stand Version I",
                    "code"  => "MF001",
                    "image" => [
                        "image/products/MF001.png",
                        [
                            'mime'      => "image/png",
                            'dirname'   => "image/products",
                            'basename'  => "MF001.png",
                            'extension' => "png",
                            'filename'  => "MF001",
                            'encoder'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUh....'
                        ]
                    ]
                ]
            ),
            'response_error' => json_encode(
                [
                    [
                        "error" => "invalid_code"
                    ],
                    [
                        "error" => "token_not_provided"
                    ],
                    [
                        "error" => "invalid_token"
                    ]
                ]
            )

        ]));

        /**
         * Product Register
         */
        dispatch(new CreateAPIHelpJob([
            'route'          => 'api.product.register',
//            'route_parameters' => json_encode(['product' => 'MF001']),
            'description'    => 'Return information about an specific product',
            'parameters'     => json_encode([
                'api_token' => 'Required - User Token',
                'code'      => 'Required - Product Code',
            ]),
            'response'       => json_encode([
                    "status" => 'okay'
                ]
            ),
            'response_error' => json_encode(
                [
                    [
                        "error" => "invalid_code"
                    ],
                    [
                        "error" => "token_not_provided"
                    ],
                    [
                        "error" => "invalid_token"
                    ],
                    [
                        "error" => " code_has_been_taken"
                    ]
                ]
            )

        ]));

        /**
         * Forms Api
         */
        /**
         * Countries
         */
        dispatch(new CreateAPIHelpJob([
            'route'          => 'api.form.countries',
            'description'    => 'Return a list with all countries',
            'parameters'     => null,
            'response'       => json_encode([
                "id"   => 50,
                "code" => "CN",
                "name" => "China (中国)"
            ]),
            'response_error' => null
        ]));

        /**
         * Ages
         */
        dispatch(new CreateAPIHelpJob([
            'route'          => 'api.form.ages',
            'description'    => 'Return a list with all ages',
            'parameters'     => null,
            'response'       => json_encode([
                "id"   => 1,
                "from" => 10,
                "to"   => 20
            ]),
            'response_error' => null
        ]));

    }

}


