<?php

class Uploader
{
    private array $queue = [];
    private bool $isPaused = false;

    public function add(string $name): void
    {
        $this->queue[] = $name;
    }

    public function start(): void
    {
        if ($this->isPaused) {
            echo "A fila está pausada.\n";
            return;
        }

        if (empty($this->queue)) {
            echo "Nenhum arquivo na fila para fazer upload.\n";
            return;
        }

        foreach ($this->queue as $file) {
            echo "Arquivo: \"{$file}\"...\n";
        }

        // Limpando a fila após o upload para evitar memory leak
        $this->queue = [];
        echo "Uploads realizado com sucesso.\n";
    }

    public function pause(): void
    {
        $this->isPaused = true;
    }

    public function restart(): void
    {
        if (!$this->isPaused) {
            return;
        }

        $this->isPaused = false;
        echo "Reiniciando upload de arquivos.\n";
        this->start();
    }
}

// Exemplo de execução dos métodos
$fileUploader = new Uploader();
// Adicionando arquivos na fila
$fileUploader->add("notes.txt");
// Iniciando o upload dos arquivos
$fileUploader->start();
// Pausa a fila
$fileUploader->pause();
// Iniciando upload, porém, isPaused = false e não será executado.
// Em um exemplo mais robusto, poderíamos tratar o feedback
$fileUploader->start();
// Reiniciando a fila
$fileUploader->restart();
// Iniciando o upload novamente
$fileUploader->start();
?>