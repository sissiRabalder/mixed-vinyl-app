<?php

//der Überordner muss immer hier stehen in dem Fall ist der VinylController im Controller Verzeichnis
//wenn das Fehlt findet PHP die Klasse nicht
namespace App\Controller;
// WARUM: extends Abstract Controller:
// Symfony-Controller-Klassen müssen keine Basisklasse erweitern.
// Solange die Controller-Funktion ein ResponseObjekt zurückgibt, ist es Symfony egal, wie der Controller aussieht.
// Aber normalerweise wird der Controller um eine Klasse namens AbstractController erweitert.


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use function Symfony\Component\String\u;

	
	class VinylController extends AbstractController
	{
		
		//Route definiert die URL
		#[Route('/')]
		public function simple(): Response
		{
			return new Response('Title: PB and Jams');
		}
		
		// wir wollen eine flexible Route z.B.: eine Route für Techno: /browse/techno, Metal browse/metal, .. usw
		//dafür wollen wir natürlich nicht immer eine einzelne Route eingaben deswegen arbeiten wir mit Variablen
		//Der Variabelname {variabelname} wird bei der Route hinzugefügt, muss dann auch bei der action hinzugefügt werden.
		// slug wird durch die Eingabe von der Route definiert. Sprich wenn ich eingebe /browse/country
		// wird als Return Genre: country ausgegeben.
		#[Route('/browse/{slug}')]
		public function browse($slug): Response
		{
			return new Response('Genre: '.$slug);
		}
		
		//browse beispiel erweitert:
		#[Route('/genres/{genre}')]
		// warum = null? Damit wenn nur /genres eingetippt ohne /.... wird kein Fehler ausgegeben wird, da ansonsten ein Parameter erwartet wird.
		// Mit null ist er standartmäßig null wenn nichts eingegeben wird und man landet auf der /genres Page
		public function genres($genre = null): Response
		{
			// damit nicht bei null 'Genre: null' ausgegeben wird -> unschön:
			
				if ($genre) {
					//entfernt die bindestriche die man bei urls benötigt (/dark-techno -> ergibt dark techno)
					//$title = str_replace('-', ' ', $genre);
					// macht das Selbe nur mehr, das ist eine Symfony Component und wertet das in Title um ausgabe (Anfangsbuchstaben Groß) nicht so wichtig aber gtn
					// oben use statemant nicht vergessen
					$title = 'Genre: '.u(str_replace('-', ' ', $genre))->title(true);
				} else {
					$title = 'All Genres';
				}
			
			return new Response($title);
		}
		
		
		//Beispiel für Klassen mit extends AbstractController
		//Wenn Templates ausgegeben werden, dann muss was anderes verwendet werden als new Response();
		//Siehe ausgabe es ist nicht new Response() sondern $this->render.
		//
		#[Route('/home')]
		public function homepage(): Response
		{
			// erstellen ein Tracks Array welches wir im Frontend ausgeben :)
			$tracks = [
		    'Sono - Keep control',
				'Deborah de Luca - I Go Out',
				'Marylin Manson - Tourniquet'
			];
			
			// erweitertes Array
			
			$songs = [
			 ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
			 ['song' => 'Waterfalls', 'artist' => 'TLC'],
			 ['song' => 'Creep', 'artist' => 'Radiohead'],
			 ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
			 ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
			 ['song' => 'Fantasy', 'artist' => 'Mariah Carey']
			];

			
			//1. Parameter ist immer das Template,
			// 2.Parameter ist ein Array mit den variablen die an das Template übergeben werden sollen
			return $this->render('vinyl/homepage.html.twig', [
			 'title'  => 'PB & Jams',
			 //hier wid das tracks-array an das frontend übergeben
				'tracks' => $tracks,
			  'songs' => $songs
			]);
			
			//die('Vinyl: Definitely NOT a fancy-looking frisbee');
		}
		

		
	}