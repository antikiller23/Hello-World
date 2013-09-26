<?php
$this->Html->css(array('jquery.dataTables'), 'stylesheet', array('inline' => FALSE));
$this->Html->script(array('jquery.dataTables.min','acls_index'),array('inline' => FALSE));
$this->set('title_for_layout', ('Administrar Acls'));
$this->extend('/Common/index_tab');
$this->set('active_id', 'by_client');
$this->set('nav_tabs',array('by_client' => __("Grupos"),
                            'by_user' => __("Usuarios")
                           )
           );

$this->assign('title', __('Acl Manager'));

$this->Html->addCrumb(__('Permissions'), '/Acls/index');

// ---------- TAB POR CLIENTES
$this->start('by_client');
?>
<div class="tab-pane fade active in" id="by_client">
    <div class="row-fluid">
        <div class="span2">
            <?php
            echo $this->element( 'acl_tab',array(
                                 'aro' => $groups,
                                 'aco' => $aco,
                                 'field' => 'Acl.group',
                                 'label' => 'Groups'
                                )
            );
            ?>
        </div>
        <div class="span10">
            <?php
            echo $this->element(
                'table',
                array(
                     'table_id' => 'Groups',
                     'headers' => array('Grupo', 'Ruta', 'Create', 'Read', 'Update', 'Delete')
                )
            );
            ?>
        </div>
    </div>
</div>
<?php $this->end();
// ---------- FIN TAB POR CLIENTES

// ---------- TAB POR USUARIOS
$this->start('by_user');
?>
<div class="tab-pane fade in" id="by_user">
    <div class="row-fluid">
        <div class="span2">
            <?php
            echo $this->element(
                'acl_tab',
                array(
                     'aro' => $users,
                     'aco' => $aco,
                     'field' => 'Acl.user',
                     'label' => 'User'
                )
            );

            ?>
        </div>
        <div class="span10">
            <?php
            echo $this->element(
                'table',
                array(
                     'table_id' => 'user_table',
                     'headers' => array('Usuario', 'Ruta', 'Create', 'Read', 'Update', 'Delete')
                )
            );
            ?>
        </div>
    </div>
</div>
<?php   $this->end();?>
