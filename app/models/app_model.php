<?php
    class AppModel extends Model
    {
        var $actsAs = array('Containable');
        var $recursive = -1;

        function find($type, $options = array())
        {
            $method = null;
            if(is_string($type))
            {
                $method = sprintf('__find%s', Inflector::camelize($type));
            }
            if($method && method_exists($this, $method))
            {
                return $this->{$method}($options);
            }
            else
            {
                $args = func_get_args();
                return call_user_func_array(array('parent', 'find'), $args);
            }
        }
    }
?>