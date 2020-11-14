<?php 

class Page {

    // Code html à afficher
    private $code_page = "";
    private $page = "";
    // theme ou l on récupère un fichier
    private $theme = "";
    private $template = "";
    private$dossier_controller = "";

    /**
     * Constructeur de page
     */
    function __construct($page = "home", $theme = "html5up-massivelly", $template = "index", $dossier_controller = "controller/"){
        // Initialisation du theme
        $this->theme = $theme;
        $this-> template = $template;
        $this->dossier_controller = $dossier_controller;
        // Si on passe une autre page que home (qui est la page par default)
        if(isset($_GET['page']))
        {
            // On ecrase home et on l'attribut
            $page = $_GET['page'];
        }
        $this->page = $page;
        
    }
// Setter pour changement de theme et de template
    function setTheme($theme){
        $this->theme = $theme;
    }
    function setTemplate($template){
        $this->template = $template;
    }

    /**
     * Undocumented function
     *
     * @param [type] $dossier_controller
     *
     * @return void
     */
    function setDossierController($dossier_controller){
        $this->dossier_controller = $dossier_controller;
    }


    function __toString(){
        return $this->code_page;
    }

    function replaceLabel($label, $text){
        $this->code_page = str_replace("{{ $label }}", $text, $this->code_page);
    }

    /**
     * Fonction d'affichage des variable twig
     *
     * @return void
     */
    function prepare(){
        include_once $this->dossier_controller . $this->page . ".php";
        $texts = controller();
        // Si on récupère un template dans $texts
        if(isset($texts['template'])){
            $this->template = $texts['template'];
        }
        // On récupère dans le theme 
        $fichier = $this->theme . "/" . $this->template . ".html.twig";
        // On récupère le contenu du fichier
        $this->code_page = file_get_contents($fichier);
        // Paramétrage du theme
        $this->replaceLabel("theme", $this->theme);
        // On initialise le menu
        $menu = "";
        // On récupère le pointer vers un dossier
        if($d = opendir($this->dossier_controller)){
            // On récupère les fichier un par un
            while($fichier = readdir($d)){
                // si [0] est différent de point on affiche
                if($fichier[0] != "."){
                    // On récupère la page à laquelle on supprime les 4 dernier caractères ( .php )
                    $page = substr($fichier, 0, -4);
                    // on remplave '_' par un éspace dans le label
                    $label = str_replace("_", " ", $page);
                    // On passe en minuscule le label et on met une majuscule sur la première lettre du label 
                    $label = ucfirst(strtolower($label));
    
                    if ($page == $this->page) {
                        $t = " class='active'";
                    } else {
                        $t = "";
                    }
                     $menu .= '<li' . $t . '><a href="index.php?page=' . $page . '">' . $label . '</a></li>';
                    }
            }
        }
        $this->replaceLabel("menu", $menu);
        
        foreach($texts as $label => $text){
            $this->replaceLabel($label, $text);
        }
    }
    
}