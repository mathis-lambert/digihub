<?php

namespace App\Models;

class DotEnvEnvironment
{

    /**
     * Loads the environment variables.
     * @param string $path The directory containing the .env file.
     * @return void
     */
    public function load($path): void
    {
        // Read the .env file.
        $lines = file($path . '/.env');

        // Loop through each line.
        foreach ($lines as $line) {
            // Split the line by the '=' sign.
            [$key, $value] = explode('=', $line, 2);

            // Trim the key and value.
            $key = trim($key);
            $value = trim($value);

            // Set the environment variables.
            putenv(sprintf('%s=%s', $key, $value));
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}
