<?php

class EmpresaEsterilizadora implements JsonSerializable {
    private $id;
    private $nombre;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre) {
        $this->nombre = $nombre;
    }

    public function jsonSerialize(): array {
        return
            [
                'id' => $this->id,
                'nombre' => $this->nombre
            ];
    }
}