<?php
App::uses('AppModel', 'Model');
/**
 * ArosAco Model
 *
 * @property Aro $Aro
 * @property Aco $Aco
 */
class ArosAco extends AppModel {
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Aro' => array(
            'className' => 'Aro',
            'foreignKey' => 'aro_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Aco' => array(
            'className' => 'Aco',
            'foreignKey' => 'aco_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
}
