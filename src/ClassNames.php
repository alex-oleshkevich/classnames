<?php

/**
 * PHP ClassName getter.
 * A missing class name extractor from PHP files.
 *
 * @link      https://github.com/alex-oleshkevich/classnames the canonical source repository.
 * @copyright Copyright (c) 2014-2016 Alex Oleshkevich <alex.oleshkevich@gmail.com>
 * @license   http://en.wikipedia.org/wiki/MIT_License MIT
 */

namespace ClassNames;

class ClassNames
{

    /**
     * Parse .php file.
     * 
     * @param string $filename
     * @return array
     */
    public function parse($filename)
    {
        $tokens = token_get_all(file_get_contents($filename));
        $classNames = [];
        $interfaceNames = [];
        $traitNames = [];
        $namespace = [];
        $curleys = 0;
        $isInNamespace = false;
        $totalTokens = count($tokens);

        for ($i = 0; $i <= $totalTokens; $i++) {
            if (!isset($tokens[$i])) {
                break;
            }

            $token = $tokens[$i];
            if (is_string($token)) {
                if (in_array($token[0], ['{'])) {
                    $curleys++;
                }

                if (in_array($token[0], ['}'])) {
                    $curleys--;
                }
                $token = [0 => $token];
            }

            // iterate until space to get FQ NS name.
            if ($token[0] == T_NAMESPACE) {
                $namespace = [];
                $i = $i + 2; 
                for (; $i <= $totalTokens; $i++) {
                    if (!isset($tokens[$i])) {
                        break;
                    }
                    $token = $tokens[$i];

                    if ($token[0] == T_STRING) {
                        $namespace[] = $token[1];
                    }

                    if ($token[0] == ';') {
                        $isInNamespace = true;
                        break;
                    }

                    if ($token[0] == '{') {
                        $curleys++;
                        break;
                    }

                    if ($token[0] == '{') {
                        $curleys--;
                    }
                }
            }

            if ($token[0] == T_CLASS) {
                $prevToken = $tokens[$i - 1];
                if (is_array($prevToken) && $prevToken[0] == T_DOUBLE_COLON) {
                    continue;
                }
                
                $i = $i + 2;
                for (; $i <= count($tokens); $i++) {
                    $token = $tokens[$i];
                    if ($token[0] == T_STRING) {
                        if ($curleys == 0 && !$isInNamespace) {
                            $namespace = [];
                        }
                        $classParts = array_merge($namespace, [$token[1]]);
                        $classNames[] = join('\\', $classParts);
                        break;
                    }
                }
            }

            if ($token[0] == T_INTERFACE) {
                $i = $i + 2;
                for (; $i <= count($tokens); $i++) {
                    $token = $tokens[$i];
                    if ($token[0] == T_STRING) {
                        if ($curleys == 0 && !$isInNamespace) {
                            $namespace = [];
                        }
                        $interfaceParts = array_merge($namespace, [$token[1]]);
                        $interfaceNames[] = join('\\', $interfaceParts);
                        break;
                    }
                }
            }

            if ($token[0] == T_TRAIT) {
                $i = $i + 2;
                for (; $i <= count($tokens); $i++) {
                    $token = $tokens[$i];
                    if ($token[0] == T_STRING) {
                        if ($curleys == 0 && !$isInNamespace) {
                            $namespace = [];
                        }
                        $traitParts = array_merge($namespace, [$token[1]]);
                        $traitNames[] = join('\\', $traitParts);
                        break;
                    }
                }
            }
        }
        return [
            'classes' => $classNames,
            'interfaces' => $interfaceNames,
            'traits' => $traitNames
        ];
    }

    /**
     * Get class names from a file.
     * 
     * @param string $filename
     * @return string[]
     */
    public function getClassNames($filename)
    {
        return $this->parse($filename)['classes'];
    }

    /**
     * Get interface names from a file.
     * 
     * @param string $filename
     * @return string[]
     */
    public function getInterfaceNames($filename)
    {
        return $this->parse($filename)['interfaces'];
    }

    /**
     * Get trait names from a file.
     * 
     * @param string $filename
     * @return string[]
     */
    public function getTraitsNames($filename)
    {
        return $this->parse($filename)['traits'];
    }

}
