<?php

namespace Plang\frontend;

use Plang\Plang;
use Plang\Scalar;

class Parser
{

    private function parseToken(string $token): mixed
    {
        if (is_numeric($token)) {
            if ($token === strval((int)$token)) {
                return new Scalar((int)$token);
            }
            return new Scalar((double)$token);
        }
        if ($token[0] === '"') {
            if ($token[mb_strlen($token) - 1] !== '"') {
                throw new \Exception("Ending of string not found");
            }
            return new Scalar(mb_substr($token, 1, mb_strlen($token) - 2));
        }
        return $token;
    }

    private function parseText(array $programText, int $lineOffset = 1): array
    {
        $text = $programText;
        $stack = [];
        $currentLine = $lineOffset;
        $program = [];
        $token = '';
        $isString = false;
        $isShielded = false;
        foreach ($text as $i => $symbol) {
            if ($symbol === "\n") {
                $currentLine++;
            }

            if ($isString) {
                if ($isShielded) {
                    $token .= $symbol;
                    $isShielded = false;
                    continue;
                }

                if ($symbol === "\\") {
                    $isShielded = true;
                    continue;
                }
                if ($symbol === '"') {
                    $isString = false;
                }
                $token .= $symbol;
                continue;
            }

            if ($symbol === '"' && empty($stack)) {
                $isString = true;
                $token .= $symbol;
                continue;
            }

            if (\IntlChar::isspace($symbol)) {
                if (mb_strlen($token) > 0) {
                    $program[] = $this->parseToken($token);
                }
                $token = '';
                continue;
            }
            if ($symbol === '(') {
                if (mb_strlen($token) > 0) {
                    $program[] = $this->parseToken($token);
                }
                $token = '';
                $stack[] = $i;
                continue;
            }
            if ($symbol === ')') {
                if (mb_strlen($token) > 0) {
                    $program[] = $this->parseToken($token);
                }
                $token = '';
                if (count($stack) === 0) {
                    throw new \Exception("Redundant closing brace at line $currentLine");
                }
                $openBraceIndex = array_pop($stack);
                if (count($stack) === 0) {
                    $program[] = $this->parseText(array_slice($text, $openBraceIndex + 1, $i - $openBraceIndex - 1));
                }
                continue;
            }

            if (!empty($stack)) {
                continue;
            }

            $token .= $symbol;
        }

        if (mb_strlen($token) > 0) {
            $program[] = $this->parseToken($token);
        }

        return $program;
    }

    /**
     * @return array Plang program
     */
    public function parse($file): array
    {
        if (!file_exists($file)) {
            throw new \Exception("File does not exists at $file");
        }

        $programText = file_get_contents($file);
        try {
            return $this->parseText(\mb_str_split($programText));
        } catch (\Throwable $throwable) {
            echo "Error\n" . $throwable->getMessage() . "\n";
            exit(22);
        }
    }

}
