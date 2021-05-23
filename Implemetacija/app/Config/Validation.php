<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	public $registration = [
        'password'     => 'required|min_length[6]',
        'email'        => 'required|valid_email|is_unique[user.email]',
        'username'     => 'required|is_unique[user.username]',
        'fullName'     => 'required|min_length[2]'
    ];

	public $registration_errors = [
        'email'        => [
            'is_unique' => 'Sorry. That email has already been taken. Please choose another.'
        ],
        'username'        => [
            'is_unique' => 'Sorry. That username has already been taken. Please choose another.'
        ]
    ];


    public $edit = [
        'password'     => 'required|min_length[6]',
        'email'        => 'required|valid_email',
        'username'     => 'required',
        'fullName'     => 'required|min_length[2]'
    ];


	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
}
