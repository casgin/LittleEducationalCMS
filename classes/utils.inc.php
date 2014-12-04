<?php
class Utils {

        /**
         * Parses INI file adding extends functionality via ":base" postfix on namespace.
         *
         * @param string $filename
         * @return array
         */
        public static function parse_ini_file_extended($filename) {
            $p_ini = parse_ini_file($filename, true);
            $config = array();
            foreach($p_ini as $namespace => $properties){
                list($name, $extends) = explode(':', $namespace);
                $name = trim($name);
                $extends = trim($extends);
                // create namespace if necessary
                if(!isset($config[$name])) $config[$name] = array();
                // inherit base namespace
                if(isset($p_ini[$extends])){
                    foreach($p_ini[$extends] as $prop => $val)
                        $config[$name][$prop] = $val;
                }
                // overwrite / set current namespace values
                foreach($properties as $prop => $val)
                $config[$name][$prop] = $val;
            }
            return $config;
        }

}