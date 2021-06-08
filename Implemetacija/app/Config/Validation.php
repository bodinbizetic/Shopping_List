<?php

namespace Config;

use CodeIgniter\Model;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;
use phpDocumentor\Reflection\Types\Integer;

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
        Validation::class
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

    /**
     * @var string[] - Pravila za validaciju polja forme prilikom registracije
     */
	public $registration = [
        'password'     => 'required|min_length[6]',
        'email'        => 'required|valid_email|is_unique[user.email]',
        'username'     => 'required|is_unique[user.username]',
        'fullName'     => 'required|min_length[2]'
    ];

    /**
     * @var string[] - Greske prilikom registracije
     */
	public $registration_errors = [
        'email'        => [
            'is_unique' => 'Sorry. That email has already been taken. Please choose another.'
        ],
        'username'        => [
            'is_unique' => 'Sorry. That username has already been taken. Please choose another.'
        ]
    ];

    /**
     * @var string[] - Pravila za validaciju polja forme za promenu user profila
     */
    public $edit = [
        'password'     => 'required|min_length[6]',
        'email'        => 'required|valid_email',
        'username'     => 'required',
        'fullName'     => 'required|min_length[2]'
    ];


	//--------------------------------------------------------------------
	// Rules

    /**
     * Proverava da li strani kljuc postoji u tabeli
     *
     * @param $id - id stranog kljuca
     * @param string $args - format argumenata: imeTabele,imeKolone,Poruka o gresci
     * @param array $data
     * @param string|null $error - poruka o gresci
     * @return bool
     */
    public function in_db($id, string $args, array $data, string &$error = null): bool {
        $model = new Model();
        $explodedArgs = explode(",", $args);
        if ($model->db->table($explodedArgs[0])->where($explodedArgs[1], $id)->get()->getNumRows() == 0) {
            if (count($explodedArgs) == 3)
                $error = $explodedArgs[2];
            else
                $error = "Not found in ".$explodedArgs[0];
            return false;
        }
        return true;
    }
	//--------------------------------------------------------------------
}
