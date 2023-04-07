<?php

//der Überordner muss immer hier stehen in dem Fall ist der VinylController im Controller Verzeichnis
//wenn das Fehlt findet PHP die Klasse nicht
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use function Symfony\Component\String\u;

	
	class VinylController
	{
		//Route definiert die URL
		#[Route('/')]
		public function homepage(): Response
		{
			return new Response('Title: PB and Jams');
			
			//die('Vinyl: Definitely NOT a fancy-looking frisbee');
		}
		
		// wir wollen eine flexible Route z.B.: eine Route für Techno: /browse/techno, Metal browse/metal, .. usw
		//dafür wollen wir natürlich nit immer eine einzelne Route eingaben deswegen arbeiten wir mit Variablen
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
		// warum = null ? Damit wenn nur /genres eingetippt ohne /.... wird kein Fehler ausgegeben wird, da ansonsten ein Parameter erwartet wird.
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
		

		
	}