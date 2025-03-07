<?php
class Note{
    private string $mailAuteur;
    private int $note;
    private string $commentaire;
    private string $date;
    private string $nomAuteur;
    private string $prenomAuteur;

    public function __construct($mailAuteur, $note, $commentaire, $date,$nomAuteur,$prenomAuteur){
        $this->mailAuteur = $mailAuteur;
        $this->note = $note;
        $this->commentaire = $commentaire;
        $this->date = $date;
        $this->nomAuteur = $nomAuteur;
        $this->prenomAuteur = $prenomAuteur;
    }

    public function getMailAuteur(){
        return $this->mailAuteur;
    }

    public function getNomAuteur(){
        return $this->nomAuteur;
    }

    public function getPrenomAuteur(){
        return $this->prenomAuteur;
    }

    public function getNote(){
        return $this->note;
    }

    public function getCommentaire(){
        return $this->commentaire;
    }

    public function getDate(){
        return $this->date;
    }

    public function setMailAuteur($mailAuteur){
        $this->mailAuteur = $mailAuteur;
    }

    public function setCommentaire($commentaire){
        $this->commentaire = $commentaire;
    }

    public function setNote($note){
        $this->note = $note;
    }

    public function setDate($date){
        $this->date = $date;
    }

    public function getDateDiff(){
        $date = date_create($this->date);
        $now = new DateTime();
        $interval = date_diff($date, $now);
        if (intval($interval->format('%y')) > 0){
            return $interval->format('%y ans');
        } else if (intval($interval->format('%m')) > 0){
            return $interval->format('%m mois');
        } else {
            return $interval->format('%d jours');
        }
    }

}