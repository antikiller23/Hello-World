<?php
App::uses('AppController', 'Controller');
/**
 * Acls Controller
 *
 * @property Acl $Acl
 */
class AclsController extends AppController {

    public $uses = array('User', 'Group', 'ArosAco', 'DefaultPermission');
    public $components = array('System','Auth','Acl','AclCheck');


    public function index() {
        if($this->AclCheck->type("Acls","create")){

        $this->set(
                'users',
                Hash::combine(
                    $this->User->find(
                        'all',
                        array(
                             'fields' => array('id', 'use_user')
                        )
                    ),
                    '{n}.User.id',
                    '{n}.User.use_user'
                )
            );

            $this->set(
                'groups',
                Hash::combine(
                    $this->Group->find(
                        'all',
                        array(
                             'fields' => array('id', 'gro_name')
                        )
                    ),
                    '{n}.Group.id',
                    '{n}.Group.gro_name'
                )
            );

            $acos = array('controllers' => __('All Controllers'));

            $controllers = $this->System->getPathList();

            foreach ($controllers as $controller => $methods) {
                $controller = str_replace('Controller', '', $controller);
                $acos[$controller]['controllers' . '/' . $controller] = __('All in ') . $controller;
                if(is_array($methods)){
                    foreach ($methods as $method) {
                        $acos[$controller]['controllers' . '/' . $controller . '/' . $method] = $method;
                    }
                }
            }

            $this->set('aco', $acos);

        }else{
            $this->Session->setFlash(__('title:Error. msg:No tienes permisos para acceder.Ponte en contacto con el administrador. img:error'), 'brain_flash');
            $this->redirect('/dashboard');
        }
    }

    public function modify() {

        if($this->AclCheck->type("Acls","create")){

            Configure::write('debug', 2);
            $this->autoRender = FALSE;

            if (
                !$this->request->is('post')
                || !$this->request->is('ajax')
            ) {
                return FALSE;
            }

            $data = $this->request->data;

            if (isset($data['Acl']['group'])) {
                $aro = $this->User->Group;
                $aro->id = $data['Acl']['group'];
            }

            if (isset($data['Acl']['user'])) {
                $aro = $this->User;
                $aro->id = $data['Acl']['user'];
            }

            switch ($data['Acl']['perm']) {
                case 'allow':
                    $result = $this->Acl->allow(
                        $aro,
                        $data['Acl']['path'],
                        $data['Acl']['action']
                    );
                    break;
                case 'deny':
                    $result = $this->Acl->deny(
                        $aro,
                        $data['Acl']['path'],
                        $data['Acl']['action']
                    );
                    break;
                case 'inherit':
                    $result = $this->Acl->inherit(
                        $aro,
                        $data['Acl']['path'],
                        $data['Acl']['action']
                    );
                    break;
            }

            return json_encode(array('status' => $result));
        }else{
            $this->Session->setFlash(__('title:Error. msg:No tienes permisos para acceder.Ponte en contacto con el administrador. img:error'), 'brain_flash');
            $this->redirect('/dashboard');
        }
    }

    public function updateTable($type = 'group') {

        if($this->AclCheck->type("Acls","create")){

            $this->autoRender = FALSE;

            if (
                !$this->request->is('get')
                || !$this->request->is('ajax')
            ) {
                return FALSE;
            }

            switch ($type) {
                case 'group':
                    $conditions = array('Aro.Model' => 'Group');
                    break;
                case 'user':
                    $conditions = array('Aro.Model' => 'User');
                    break;
                default:
                    $conditions = array();
            }

            $arosacos = $this->ArosAco->find(
                'all',
                array('conditions' => $conditions)
            );

            $rows = array();

            foreach ($arosacos as $rc) {
                $rows[] = array(
                    $rc['Aro']['alias'],
                    $rc['Aco']['alias'],
                    $rc['ArosAco']['_create'],
                    $rc['ArosAco']['_read'],
                    $rc['ArosAco']['_update'],
                    $rc['ArosAco']['_delete'],
                );
            }

            return json_encode(
                array(
                     "bPaginate" => FALSE,
                     "bLengthChange" => FALSE,
                     "bFilter" => FALSE,
                     "asStripClasses" => NULL,
                     "bSortClasses" => FALSE,
                     "bSort" => TRUE,
                     "bInfo" => FALSE,
                     "bAutoWidth" => FALSE,
                     "bDestroy" => TRUE,
                     'aaData' => $rows
                )
            );
        }else{
            $this->Session->setFlash(__('title:Error. msg:No tienes permisos para acceder.Ponte en contacto con el administrador. img:error'), 'brain_flash');
            $this->redirect('/dashboard');
        }
    }

    public function setDefault() {
        if($this->AclCheck->type("Acls","create")){

            Configure::write('debug', 2);
            $this->autoRender = FALSE;
            $data = $this->request->data;

            if (
                !$this->request->is('post')
                || !$this->request->is('ajax')
                || !isset($data['DefaultPermission']['action'])
                || empty($data['DefaultPermission']['action'])
                || !isset($data['DefaultPermission']['path'])
                || empty($data['DefaultPermission']['path'])
            ) {
                return FALSE;
            }
            $this->DefaultPermission->create();
            $this->DefaultPermission->save($data['DefaultPermission']);

            return TRUE;
        }else{
            $this->Session->setFlash(__('title:Error. msg:No tienes permisos para acceder.Ponte en contacto con el administrador. img:error'), 'brain_flash');
            $this->redirect('/dashboard');
        }
    }

    public function updateDefaultTable() {
        if($this->AclCheck->type("Acls","create")){

            Configure::write('debug', 2);
            $this->autoRender = FALSE;

            if (
                !$this->request->is('get')
                || !$this->request->is('ajax')
            ) {
                return FALSE;
            }

            $defaults = $this->DefaultPermission->find('all', array('fields' => array('action', 'path')));

            if (empty($defaults)) {
                return json_encode(
                    array(
                         "bPaginate" => FALSE,
                         "bLengthChange" => FALSE,
                         "bFilter" => FALSE,
                         "asStripClasses" => NULL,
                         "bSortClasses" => FALSE,
                         "bSort" => TRUE,
                         "bInfo" => FALSE,
                         "bAutoWidth" => FALSE,
                         "bDestroy" => TRUE
                    )
                );
            }
            $rows = array();
            foreach ($defaults as $default) {
                $rows[] = array(
                    $default['DefaultPermission']['action'],
                    $default['DefaultPermission']['path']
                );
            }

            return json_encode(
                array(
                     "bPaginate" => FALSE,
                     "bLengthChange" => FALSE,
                     "bFilter" => FALSE,
                     "asStripClasses" => NULL,
                     "bSortClasses" => FALSE,
                     "bSort" => TRUE,
                     "bInfo" => FALSE,
                     "bAutoWidth" => FALSE,
                     "bDestroy" => TRUE,
                     'aaData' => $rows
                )
            );
        }else{
            $this->Session->setFlash(__('title:Error. msg:No tienes permisos para acceder.Ponte en contacto con el administrador. img:error'), 'brain_flash');
            $this->redirect('/dashboard');
        }
    }

    public function sync() {
        if($this->AclCheck->type("Acls","create")){

            Configure::write('debug', 2);
            $this->autoRender = FALSE;
            if (
                !$this->request->is('get')
                || !$this->request->is('ajax')
            ) {
                return FALSE;
            }

            $this->Group->recursive = -1;
            $clients = $this->Group->find(
                'all',
                array(
                     'conditions' => array('id <>' => 1),
                     'fields' => array('id'),
                )
            );

            foreach ($clients as $client) {
                $this->ArosAco->deleteAll(
                    array(
                         'aro_id' => $this->Acl->Aro->field(
                             'id',
                             array('model' => 'Group', 'foreign_key' => $client['Group']['id'])
                         )
                    )
                );
                $this->Group->id = $client['Group']['id'];
                $this->System->defaultPermissions($this->Group);
            }

            return json_encode(array('txt' => 'Sync Done!'));
        }else{
            $this->Session->setFlash(__('title:Error. msg:No tienes permisos para acceder.Ponte en contacto con el administrador. img:error'), 'brain_flash');
            $this->redirect('/dashboard');
        }
    }
}
