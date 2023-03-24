<?php

namespace CostAclNavigation\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use CostAuthorization\Model\Entity\Permissions as Permissions;

/**
 * Menus
 *
 * @ORM\Table(name="menus")
 * @ORM\Entity(repositoryClass="CostAclNavigation\Model\Entity\Repository\MenusRepo")
 */
class Menus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    protected $parentId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     */
    protected $label;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255, nullable=false)
     */
    protected $route;

    /**
     * @var string
     *
     * @ORM\Column(name="controller", type="string", length=255, nullable=false)
     */
    protected $controller;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255, nullable=false)
     */
    protected $action;

    /**
     * @var string
     *
     * @ORM\Column(name="resource", type="string", length=255, nullable=true)
     */
    protected $resource;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\CostAuthorization\Model\Entity\Permissions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="privilege", referencedColumnName="id")
     * })
     */
    protected  $permission;

    
    /**
     * @ORM\Column(name="params", type="string", length=255, nullable=true)
     * @var unknown
     */
    protected  $params;
    
    /**
     * @ORM\Column(name="query", type="string", length=255, nullable=true)
     * @var unknown
     */
    protected  $query;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="module", type="string", length=255, nullable=false)
     */
    protected $module;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255, nullable=false)
     */
    protected $icon;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255, nullable=true)
     */
    protected $class;
    

    /**
     * @var integer
     *
     * @ORM\Column(name="sort_order", type="integer", nullable=false)
     */
    protected $order;
    



    /**
     * @return the $class
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return Menus
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Menus
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Menus
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return Menus
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set controller
     *
     * @param string $controller
     *
     * @return Menus
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Get controller
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Set action
     *
     * @param string $action
     *
     * @return Menus
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set resource
     *
     * @param string $resource
     *
     * @return Menus
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set privilege
     *
     * @param string $privilege
     *
     * @return Menus
     */
    public function setPermission(\CostAuthorization\Model\Entity\Permissions $privilege)
    {
        $this->permission = $privilege;
        return $this;
    }

    /**
     * Get privilege for tablegateway hidrator
     *
     * @return string
     */
    public function getPrivilege()
    {
        return $this->permission;
    }
    
    /**
     * 
     * @param strig $privilege
     */
    public function setPrivilege($privilege)
    {
        $this->permission = $privilege;
        return $this;
    }
    
    /**
     * Get privilege
     *
     * @return string
     */
    public function getPermission()
    {
        return $this->permission;
    }
    
    

    /**
     * Set module
     *
     * @param string $module
     *
     * @return Menus
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return Menus
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * 
     * @param string $icon
     * @return string
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    /**
     * 
     * @param string $params
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }

    /**
     * 
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }
 
 
}
