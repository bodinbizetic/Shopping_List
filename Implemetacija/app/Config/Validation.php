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

	//--------------------------------------------------------------------
	// Rules

    public function in_db($id, string $args, array $data, string &$error = null): bool {
        $model = new Model();
        $explodedArgs = explode(",", $args);
        if ($model->db->table($explodedArgs[0])->where($explodedArgs[1], $id)->get()->getNumRows() == 0) {
            $error = $explodedArgs[2];
            return false;
        }
        return true;
    }
	//--------------------------------------------------------------------
}
