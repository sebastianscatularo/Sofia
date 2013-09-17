<?php

namespace Sofia;

interface Container {

    /**
     * Method to register class data
     * 
     * @package Sofia
     * @author Sebastian Scatualro <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @param string $className Class name included namespace if is necesary
     * @param string $methodFactory Static method to create a new instance
     * @return void
    */
    public function register($id, $className, $methodFactory = null);

    /** 
     * Method to set dependency relation between two or more classes
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param String $id Class identifier
     * @param array $dependencies Array of dependencies
     * @example array (
     *              array("Object" => "id"),
     *              array("String" => "value"),
     *              array("Number" => "value"),
     *              array("Bool" => "value")
     *          )
     * NOTE "respect the order"
     * @return void
    */
    public function inject($id, array $dependencies);

    /** 
     * Method to set dependency relation between two classes
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @param string $id Injected class identifier
     * @return void
    */
    public function injectObject($id, $object);

    /** 
     * Method to set dependency relation between a class and String value
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @param string $id Injected String value
     * @return void
    */
    public function injectString($id, $string);

    /** 
     * Method to set dependency relation between a class and Number value
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @param string $id Injected Number value
     * @return void
    */
    public function injectNumber($id, $number);

    /** 
     * Method to set dependency relation between a class and Boolean value
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @param string $id Injected Boolean value
     * @return void
    */
    public function injectBoolean($id, $boolean);

    /** 
     * Method to get a new instance 
     * 
     * @package Sofia
     * @author Sebastian Scatularo <sebastianscatularo@gmail.com>
     * @param string $id Class identifier
     * @return object Object instance related to class identifier
    */
    public function get($id);
}