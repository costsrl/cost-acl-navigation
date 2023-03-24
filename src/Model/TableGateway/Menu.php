<?php
namespace CostAclNavigation\Model\TableGateway;

use Laminas\Db\Sql;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Db\Sql\Expression;
use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Paginator\Adapter\Iterator;
use Laminas\Paginator\Adapter\ArrayAdapter;
use Laminas\Paginator\Paginator;
use Laminas\Db\ResultSet\ResultSet;

use Laminas\Db\TableGateway\Feature\GlobalAdapterFeature;
use Laminas\Db\TableGateway\Feature\EventFeature;
use Laminas\Db\TableGateway\Feature\FeatureSet;
use Laminas\ServiceManager\ServiceManager;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\Db\TableGateway\AbstractTableGateway;
use CostBase\Model\TableGateway\BasicTableGateway as BasicTableGateway;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\Factory as InputFactory;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;

class Menu extends BasicTableGateway implements InputFilterAwareInterface
{
    
    
    
    /**
     *
     * @param string $where
     * @return Ambigous <\Laminas\Db\Sql\Select, \Laminas\Db\Sql\Select>
     */
    public function getDefaultSql($where=null)
    {
        $sql= new \Laminas\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select()
        ->from(array('m'=>$this->table))
        ->columns(array('id', 'parent_id', 'name', 'label', 'route', 'controller', 'action', 'privilege', 'resource','module', 'icon','class','sort_order','query','params'))
        ->join(array('pr'=>'permissions'),'pr.id = m.privilege', array('privilege_name'=>'privilege'),'INNER');
        //echo $sql->getSqlStringForSqlObject($select);
        return $select;
    }
    
    
    public function getNavigatorSql($module=null)
    {
        $sql= new \Laminas\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select()
        ->from(array('m'=>$this->table))
        ->columns(array('id', 'parent_id', 'name', 'label', 'route', 'controller', 'action', 'privilege', 'resource','module','icon' ,'class','sort_order','query','params'))
        ->join(array('pr'=>'permissions'),'pr.id = m.privilege', array('privilege_name'=>'privilege'),'INNER')->order(array('sort_order'=>'ASC','id'=>'ASC','parent_id'=>'ASC'));
         if($module!==null){
            $where = new Where();
            $where->equalTo('module', $module);
            $select->where($where);
        }
        //echo $sql->getSqlStringForSqlObject($select);
        return $select;
    }
    
    
    /**
     *  Estraggo elenco voci menu del singolo modulo
     * @param string $module
     * @return array 
     */
    public function getNavigatorByModule($module=null)
    {
        $sql= new \Laminas\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select()
        ->from(array('m'=>$this->table))
        ->columns(array('id', 'parent_id', 'name', 'label', 'route', 'controller', 'action', 'privilege', 'resource','module','icon', 'sort_order','query','params'))
        ->join(array('pr'=>'permissions'),'pr.id = m.privilege', array('privilege_name'=>'privilege'),'INNER')->order(array('sort_order'=>'ASC','id'=>'ASC','parent_id'=>'ASC'));
        if($module!==null){
            $where = new Where();
            $where->equalTo('module', $module);
            $select->where($where);
        }
        return $this->selectWith($select);
    }
    
    
    
    /** ESTRAZIONI CON COMBO **/
    public function fetchPairs($flag=true){
        $sql= new \Laminas\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select();
        $select->from($this->table);
        $select->columns(array('id','name'))->order('id ASC, parent_id ASC');
        $result = $this->selectWith($select)->toArray();
        $rs=$this->selectWith($select)->toArray();
        if($flag) $return[0]= '-';
        foreach ($rs as $row) {
            $row = array_values($row);
            $return[trim($row[0])] = trim($row[1]);
        }
    
        return $return;
    }
    
    
    
    
    
    /**
     * @return string
     */
    protected function generateKey(){
        return md5($this->table);
    }
    
    
    /**
     * (non-PHPdoc)
     * @see \Laminas\Db\TableGateway\AbstractTableGateway::__call()
     */
    public function __call($method, $arguments){
        $this->table->$method($arguments);
    }
    
    
    
    public function getInputFilter()
    {
    
        if (!$this->inputFilter) {
            $inputFilter        = new InputFilter();
            $factory            = new InputFactory();
            
            //'parent_id', 'name', 'label', 'route', 'controller', 'action', 'privilege', 'resource','module', 'icon','sort_order'
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'parent_id',
                'required' => true,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'name',
                'required' => false,
                'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            )));
            
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'label',
                'required' => true,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'route',
                'required' => true,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'controller',
                'required' => true,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'action',
                'required' => true,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'privilege',
                'required' => true,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'resource',
                'required' => true,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'module',
                'required' => true,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'icon',
                'required' => false,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'sort_order',
                'required' => true,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'params',
                'required' => false,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'class',
                'required' => false,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'query',
                'required' => false,
                /*'filters'  => array(
                 array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            'validators'=>array()
            */
            )));
            
            $this->inputFilter  = $inputFilter;
            
            
        
        }
    
        return $this->inputFilter;
    
    }
    
    
    public function setInputFilter(InputFilterInterface $inputFilter){
        throw new RuntimeException('Method not allowed', 500);
    }
    
    
    
}

?>