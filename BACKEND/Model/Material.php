<?php

class Material implements JsonSerializable {
    private $id;
    private $operador;
    private $fecha;
    private $hora;
    private $paciente;
    private $numeroHistoriaClinica;
    private $descripcionMaterial;
    private $medicoSolicitante;
    private $pesoDeLaCaja;
    private $proveedor;
    private $empresa;
    private $metodo;
    private $observaciones;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getOperador() {
        return $this->operador;
    }

    public function setOperador($operador) {
        $this->operador = $operador;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

    public function getPaciente() {
        return $this->paciente;
    }

    public function setPaciente($paciente) {
        $this->paciente = $paciente;
    }

    public function getNumeroHistoriaClinica() {
        return $this->numeroHistoriaClinica;
    }

    public function setNumeroHistoriaClinica($numeroHistoriaClinica) {
        $this->numeroHistoriaClinica = $numeroHistoriaClinica;
    }

    public function getDescripcionMaterial() {
        return $this->descripcionMaterial;
    }

    public function setDescripcionMaterial($descripcionMaterial) {
        $this->descripcionMaterial = $descripcionMaterial;
    }

    public function getMedicoSolicitante() {
        return $this->medicoSolicitante;
    }

    public function setMedicoSolicitante($medicoSolicitante) {
        $this->medicoSolicitante = $medicoSolicitante;
    }

    public function getPesoDeLaCaja() {
        return $this->pesoDeLaCaja;
    }

    public function setPesoDeLaCaja($pesoDeLaCaja) {
        $this->pesoDeLaCaja = $pesoDeLaCaja;
    }

    public function getProveedor() {
        return $this->proveedor;
    }

    public function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    public function getMetodo() {
        return $this->metodo;
    }

    public function setMetodo($metodo) {
        $this->metodo = $metodo;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    

    public function jsonSerialize(): array {
        return
            [
                'id' => $this->id,
                'operador' => $this->operador,
                'fecha' => $this->fecha,
                'hora' => $this->hora,
                'paciente' => $this->paciente,
                'numeroHistoriaClinica' => $this->numeroHistoriaClinica,
                'descripcionMaterial' => $this->descripcionMaterial,
                'medicoSolicitante' => $this->medicoSolicitante,
                'pesoDeLaCaja' => $this->pesoDeLaCaja,
                'proveedor' => $this->proveedor,
                'empresa' => $this->empresa,
                'metodo' => $this->metodo,
                'observaciones' => $this->observaciones
            ];
    }
}