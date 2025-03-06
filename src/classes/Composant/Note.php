<?php
class Note{
    private string $mailAuteur;
    private int $note;
    private string $commentaire;
    private string $date;

    public function __construct($mailAuteur, $note, $commentaire, $date){
        $this->mailAuteur = $mailAuteur;
        $this->note = $note;
        $this->commentaire = $commentaire;
        $this->date = $date;
    }

    public function getMailAuteur(){
        return $this->mailAuteur;
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

    public function getNomAuteur(){
        #TODO
        return "Auteur";
    }

    public function getPrenomAuteur(){
        #TODO
        return "Prenom";
    }

}