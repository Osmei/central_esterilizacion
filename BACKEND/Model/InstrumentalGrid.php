<?php

class InstrumentalGrid implements JsonSerializable {
    
    private $id;
    private $operador;
    private $paciente;
    private $numeroHistoriaClinica;
    private $medicoSolicitante;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getOperador(): ?string {
        return $this->operador;
    }

    public function setOperador(?string $operador) {
        $this->operador = $operador;
    }

    public function getPaciente(): ?string {
        return $this->paciente;
    }

    public function setPaciente(?string $paciente) {
        $this->paciente = $paciente;
    }

    public function getNumeroHistoriaClinica(): ?int {
        return $this->numeroHistoriaClinica;
    }

    public function setNumeroHistoriaClinica(?int $numeroHistoriaClinica) {
        $this->numeroHistoriaClinica = $numeroHistoriaClinica;
    }

    public function getMedicoSolicitante(): ?string {
        return $this->medicoSolicitante;
    }

    public function setMedicoSolicitante(?string $medicoSolicitante) {
        $this->medicoSolicitante = $medicoSolicitante;
    }    

    public function jsonSerialize(): array {
        return
            [
                'id' => $this->id,
                'operador' => $this->operador,
                'paciente' => $this->paciente,
                'numeroHistoriaClinica' => $this->numeroHistoriaClinica,
                'medicoSolicitante' => $this->medicoSolicitante
            ];
    }
}