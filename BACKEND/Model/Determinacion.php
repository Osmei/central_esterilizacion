<?php

class Determinacion implements JsonSerializable {
    private $id;
    private $titulo;
    private $descripcion;
    private $activo;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }

    public function setTitulo(string $titulo) {
        $this->titulo = $titulo;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getActivo(): bool {
        return $this->activo;
    }

    public function setActivo(bool $activo) {
        $this->activo = $activo;
    }

    public function jsonSerialize(): array {
        return
            [
                'id' => $this->id,
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
                'activo' => $this->activo
            ];
    }
}

?>