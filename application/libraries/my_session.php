<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session
{
    function __construct($config = array())
    {
        parent::__construct($config);
    }

    /**
     * Serialize an array
     *
     * This function first converts any slashes found in the array to a temporary
     * marker, so when it gets unserialized the slashes will be preserved
     *
     * @access  private
     * @param   array
     * @return  string
     */
    function _serialize($data)
    {
        if (is_array($data))
        {
            array_walk_recursive($data, function(&$item,$key){
                if (is_string($item))
                {
                    $item = str_replace('\\', '{{slash}}', $item);
                }
            });
        }
        else
        {
            if (is_string($data))
            {
                $data = str_replace('\\', '{{slash}}', $data);
            }
        }

        return serialize($data);
    }

    // --------------------------------------------------------------------

    /**
     * Unserialize
     *
     * This function unserializes a data string, then converts any
     * temporary slash markers back to actual slashes
     *
     * @access  private
     * @param   array
     * @return  string
     */
    function _unserialize($data)
    {
        $data = unserialize(strip_slashes($data));
        if (is_array($data))
        {
            array_walk_recursive($data, function(&$item,$key){
                if (is_string($item))
                {
                    $item = str_replace('{{slash}}', '\\', $item);
                }
            });

            return $data;
        }

        return (is_string($data)) ? str_replace('{{slash}}', '\\', $data) : $data;
    }
}