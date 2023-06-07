<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Knp\Bundle\TimeBundle\DateTimeFormatter;
use Symfony\Contracts\Cache\CacheInterface;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Symfony\Component\String\u;

	
	class VinylController extends AbstractController
	{
		
		#[Route('/browse/{slug}', name: 'app_browse')]
		// 2) damit wird der cache irgendwann voll sein also mit chae ein wenig komplizierter geschrieben siehe weiter unten wird der code auch erweitert
		//public function browse(HttpClientInterface $httpClient, string $slug = null): Response
		public function browse(HttpClientInterface $httpClient, CacheInterface $cache, string $slug = null): Response
		
		{
			$genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
//			$mixes = $this->getMixes();
			
			//2) hier weiterfügrung cache
		//	$response = $httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
		//	$mixes = $response->toArray();
			
			$mixes = $cache->get('mixes_data', function() use ($httpClient) {
				$response = $httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
				return $response->toArray();
			});
			
/*			// ein neues Array in Array pushen
			foreach ($mixes as $key => $mix) {
				//der key für neues Array ist 'ago' mit dem wert =
				$mixes[$key]['ago'] = $timeFormatter->formatDiff($mix['createdAt']);
				
			}
			*/
			return $this->render('vinyl/browse.html.twig', [
			 'genre' => $genre,
			 'mixes' => $mixes,
			]);
		}
		
		private function getMixes(): array
		{
			// temporary fake "mixes" data
			return [
			 [
				'title' => 'PBA & Jams',
				'trackCount' => 19,
				'genre' => 'Rock',
				'createdAt' => new \DateTime('2021-10-02'),
			 ],
			 [
				'title' => 'Put a Hex on your Ex',
				'trackCount' => 8,
				'genre' => 'Heavy Metal',
				'createdAt' => new \DateTime('2022-04-28'),
			 ],
			 [
				'title' => 'Spice Grills - Summer Tunes',
				'trackCount' => 10,
				'genre' => 'Pop',
				'createdAt' => new \DateTime('2019-06-20'),
			 ],
			];
		}
		
		
		#[Route('/', name: 'app_homepage')]
		public function homepage(): Response
		{

			
			$songs = [
			 ['title' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
			 ['title' => 'Waterfalls', 'artist' => 'TLC'],
			 ['title' => 'Creep', 'artist' => 'Radiohead'],
			 ['title' => 'Kiss from a Rose', 'artist' => 'Seal'],
			 ['title' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
			 ['title' => 'Fantasy', 'artist' => 'Mariah Carey']
			];

			
			return $this->render('vinyl/homepage.html.twig', [
			 'title'  => 'PB & Jams',
			 //hier wid das tracks-array an das frontend übergeben
				'tracks' => $songs,
			  'songs' => $songs
			]);
		}
		

		
	}