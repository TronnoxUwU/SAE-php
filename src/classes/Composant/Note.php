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


}