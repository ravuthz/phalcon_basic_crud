<?php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

class Notes extends \Phalcon\Mvc\Model {
    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $note;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $date;

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSchema("phalcon_basic_crud");
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation() {
        $validator = new Validation();

        $validator->add(
            'name',
            new UniquenessValidator([
                'model'   => $this,
                'message' => 'Sorry, That name is already taken'
            ])
        );

        return $this->validate($validator);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'notes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Notes[]|Notes
     */
    public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Notes
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
