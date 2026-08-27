<?php
class Horloge
{
    private string $heureMinute;
    private string $heure;

    public function __construct(string $timeZone)
    {
        date_default_timezone_set($timeZone);
        $this->heureMinute = date("H:i");
        $this->heure = date("H");
    }

    public function obtenirHeureMinute()
    {
        return $this->heureMinute;
    }

    public function obtenirHeure()
    {
        return $this->heure;
    }

    public function obtenirMessage()
    {
        if ($this->heure < 12) {
            return 'Bonne avant-midi';
        }

        if ($this->heure > 12 and $this->heure < 18) {
            return 'Bonne après-midi';
        }

        return 'Bonne soirée';
    }
}
