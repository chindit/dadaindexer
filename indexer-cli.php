<?php

	//------------------------
	//USER DATA : FEEL FREE TO MODIFY THIS
	//------------------------
	//Path to store thumbnails
	$infos['thumbsPath'] = 'Photos/System/thumbs/';
	//Path to store duplicate files
	$infos['duplicatePath'] = 'Photos/System/doublons/';
	//Size for thumbnails
	$infos['thumbSize'] = array('width' => 85, 'height' => 85);
	//Types of files which will NOT be indexed
	$infos['ignoredMime'] = array('text/plain', 'text/html', 'text/html', 'text/html', 'text/css', 'text/x-php', 'application/javascript', 'application/json', 'application/xml');
	//Directories which will NOT be indexed
	$infos['ignoredDir'] = array('System');
	//Base de données
	$infos['sql'] = array('server' => 'localhost', 'base' => 'mybase', 'user' => 'myuser', 'pass' => 'mypass');
	
	//------------------------
	//END OF USER DATA : DO NO MODIFY THIS CODE UNLESS YOU KNOW WHAT YOU'RE DOING!
	//------------------------
	
	/*
	LICENSE
	
	The GNU General Public License (GPL-2.0)
	Version 2, June 1991

	Copyright (C) 1989, 1991 Free Software Foundation, Inc.
	51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA

	Everyone is permitted to copy and distribute verbatim copies
	of this license document, but changing it is not allowed.

	Preamble

	The licenses for most software are designed to take away your freedom to share and change it. By contrast, the GNU General Public License is intended to guarantee your freedom to share and change free software--to make sure the software is free for all its users. This General Public License applies to most of the Free Software Foundation's software and to any other program whose authors commit to using it. (Some other Free Software Foundation software is covered by the GNU Library General Public License instead.) You can apply it to your programs, too.

	When we speak of free software, we are referring to freedom, not price. Our General Public Licenses are designed to make sure that you have the freedom to distribute copies of free software (and charge for this service if you wish), that you receive source code or can get it if you want it, that you can change the software or use pieces of it in new free programs; and that you know you can do these things.

	To protect your rights, we need to make restrictions that forbid anyone to deny you these rights or to ask you to surrender the rights. These restrictions translate to certain responsibilities for you if you distribute copies of the software, or if you modify it.

	For example, if you distribute copies of such a program, whether gratis or for a fee, you must give the recipients all the rights that you have. You must make sure that they, too, receive or can get the source code. And you must show them these terms so they know their rights.

	We protect your rights with two steps: (1) copyright the software, and (2) offer you this license which gives you legal permission to copy, distribute and/or modify the software.

	Also, for each author's protection and ours, we want to make certain that everyone understands that there is no warranty for this free software. If the software is modified by someone else and passed on, we want its recipients to know that what they have is not the original, so that any problems introduced by others will not reflect on the original authors' reputations.

	Finally, any free program is threatened constantly by software patents. We wish to avoid the danger that redistributors of a free program will individually obtain patent licenses, in effect making the program proprietary. To prevent this, we have made it clear that any patent must be licensed for everyone's free use or not licensed at all.

	The precise terms and conditions for copying, distribution and modification follow.

	TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

	0. This License applies to any program or other work which contains a notice placed by the copyright holder saying it may be distributed under the terms of this General Public License. The "Program", below, refers to any such program or work, and a "work based on the Program" means either the Program or any derivative work under copyright law: that is to say, a work containing the Program or a portion of it, either verbatim or with modifications and/or translated into another language. (Hereinafter, translation is included without limitation in the term "modification".) Each licensee is addressed as "you".

	Activities other than copying, distribution and modification are not covered by this License; they are outside its scope. The act of running the Program is not restricted, and the output from the Program is covered only if its contents constitute a work based on the Program (independent of having been made by running the Program). Whether that is true depends on what the Program does.

	1. You may copy and distribute verbatim copies of the Program's source code as you receive it, in any medium, provided that you conspicuously and appropriately publish on each copy an appropriate copyright notice and disclaimer of warranty; keep intact all the notices that refer to this License and to the absence of any warranty; and give any other recipients of the Program a copy of this License along with the Program.

	You may charge a fee for the physical act of transferring a copy, and you may at your option offer warranty protection in exchange for a fee.

	2. You may modify your copy or copies of the Program or any portion of it, thus forming a work based on the Program, and copy and distribute such modifications or work under the terms of Section 1 above, provided that you also meet all of these conditions:

		a) You must cause the modified files to carry prominent notices stating that you changed the files and the date of any change.

		b) You must cause any work that you distribute or publish, that in whole or in part contains or is derived from the Program or any part thereof, to be licensed as a whole at no charge to all third parties under the terms of this License.

		c) If the modified program normally reads commands interactively when run, you must cause it, when started running for such interactive use in the most ordinary way, to print or display an announcement including an appropriate copyright notice and a notice that there is no warranty (or else, saying that you provide a warranty) and that users may redistribute the program under these conditions, and telling the user how to view a copy of this License. (Exception: if the Program itself is interactive but does not normally print such an announcement, your work based on the Program is not required to print an announcement.)

	These requirements apply to the modified work as a whole. If identifiable sections of that work are not derived from the Program, and can be reasonably considered independent and separate works in themselves, then this License, and its terms, do not apply to those sections when you distribute them as separate works. But when you distribute the same sections as part of a whole which is a work based on the Program, the distribution of the whole must be on the terms of this License, whose permissions for other licensees extend to the entire whole, and thus to each and every part regardless of who wrote it.

	Thus, it is not the intent of this section to claim rights or contest your rights to work written entirely by you; rather, the intent is to exercise the right to control the distribution of derivative or collective works based on the Program.

	In addition, mere aggregation of another work not based on the Program with the Program (or with a work based on the Program) on a volume of a storage or distribution medium does not bring the other work under the scope of this License.

	3. You may copy and distribute the Program (or a work based on it, under Section 2) in object code or executable form under the terms of Sections 1 and 2 above provided that you also do one of the following:

		a) Accompany it with the complete corresponding machine-readable source code, which must be distributed under the terms of Sections 1 and 2 above on a medium customarily used for software interchange; or,

		b) Accompany it with a written offer, valid for at least three years, to give any third party, for a charge no more than your cost of physically performing source distribution, a complete machine-readable copy of the corresponding source code, to be distributed under the terms of Sections 1 and 2 above on a medium customarily used for software interchange; or,

		c) Accompany it with the information you received as to the offer to distribute corresponding source code. (This alternative is allowed only for noncommercial distribution and only if you received the program in object code or executable form with such an offer, in accord with Subsection b above.)

	The source code for a work means the preferred form of the work for making modifications to it. For an executable work, complete source code means all the source code for all modules it contains, plus any associated interface definition files, plus the scripts used to control compilation and installation of the executable. However, as a special exception, the source code distributed need not include anything that is normally distributed (in either source or binary form) with the major components (compiler, kernel, and so on) of the operating system on which the executable runs, unless that component itself accompanies the executable.

	If distribution of executable or object code is made by offering access to copy from a designated place, then offering equivalent access to copy the source code from the same place counts as distribution of the source code, even though third parties are not compelled to copy the source along with the object code.

	4. You may not copy, modify, sublicense, or distribute the Program except as expressly provided under this License. Any attempt otherwise to copy, modify, sublicense or distribute the Program is void, and will automatically terminate your rights under this License. However, parties who have received copies, or rights, from you under this License will not have their licenses terminated so long as such parties remain in full compliance.

	5. You are not required to accept this License, since you have not signed it. However, nothing else grants you permission to modify or distribute the Program or its derivative works. These actions are prohibited by law if you do not accept this License. Therefore, by modifying or distributing the Program (or any work based on the Program), you indicate your acceptance of this License to do so, and all its terms and conditions for copying, distributing or modifying the Program or works based on it.

	6. Each time you redistribute the Program (or any work based on the Program), the recipient automatically receives a license from the original licensor to copy, distribute or modify the Program subject to these terms and conditions. You may not impose any further restrictions on the recipients' exercise of the rights granted herein. You are not responsible for enforcing compliance by third parties to this License.

	7. If, as a consequence of a court judgment or allegation of patent infringement or for any other reason (not limited to patent issues), conditions are imposed on you (whether by court order, agreement or otherwise) that contradict the conditions of this License, they do not excuse you from the conditions of this License. If you cannot distribute so as to satisfy simultaneously your obligations under this License and any other pertinent obligations, then as a consequence you may not distribute the Program at all. For example, if a patent license would not permit royalty-free redistribution of the Program by all those who receive copies directly or indirectly through you, then the only way you could satisfy both it and this License would be to refrain entirely from distribution of the Program.

	If any portion of this section is held invalid or unenforceable under any particular circumstance, the balance of the section is intended to apply and the section as a whole is intended to apply in other circumstances.

	It is not the purpose of this section to induce you to infringe any patents or other property right claims or to contest validity of any such claims; this section has the sole purpose of protecting the integrity of the free software distribution system, which is implemented by public license practices. Many people have made generous contributions to the wide range of software distributed through that system in reliance on consistent application of that system; it is up to the author/donor to decide if he or she is willing to distribute software through any other system and a licensee cannot impose that choice.

	This section is intended to make thoroughly clear what is believed to be a consequence of the rest of this License.

	8. If the distribution and/or use of the Program is restricted in certain countries either by patents or by copyrighted interfaces, the original copyright holder who places the Program under this License may add an explicit geographical distribution limitation excluding those countries, so that distribution is permitted only in or among countries not thus excluded. In such case, this License incorporates the limitation as if written in the body of this License.

	9. The Free Software Foundation may publish revised and/or new versions of the General Public License from time to time. Such new versions will be similar in spirit to the present version, but may differ in detail to address new problems or concerns.

	Each version is given a distinguishing version number. If the Program specifies a version number of this License which applies to it and "any later version", you have the option of following the terms and conditions either of that version or of any later version published by the Free Software Foundation. If the Program does not specify a version number of this License, you may choose any version ever published by the Free Software Foundation.

	10. If you wish to incorporate parts of the Program into other free programs whose distribution conditions are different, write to the author to ask for permission. For software which is copyrighted by the Free Software Foundation, write to the Free Software Foundation; we sometimes make exceptions for this. Our decision will be guided by the two goals of preserving the free status of all derivatives of our free software and of promoting the sharing and reuse of software generally.

	NO WARRANTY

	11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW. EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE. THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU. SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING, REPAIR OR CORRECTION.

	12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.

	END OF TERMS AND CONDITIONS
	*/
	
	//-----------------------------------
	// Traitement des données utilisateur
	//-----------------------------------
	//Panneau général d'options
	$infos['sql']['options'] = array('utf8' => false, 'emulate' => false, 'driver' => 'mysql');
	$infos['workingDir'] = '.';
	$mainArgs = array('index', 'mkthumbs', 'clean-index', 'clean-thumbs', 'checkfiletype', 'help');
	$currentArg = '';
	$infos['keepRatio'] = false;
	$infos['fullDuplicate'] = false;
	$infos['simulate'] = false;
	
	//Détection de l'argument principal
	if((count($argv) >= 2) && in_array($argv[1], $mainArgs)){
		$currentArg = $argv[1];
	}
	else{
		exit('You need to enter at least 1 command to run the script.  Type «help» to see a list of available commands.');
	}
	
	//Détection des arguments
	if(count($argv) > 2){
		for($i=2; $i<count($argv); $i++){
			//Détection du dernier argument qui peut être un dossier
			if((strpos($argv[$i], '--') === false) && ($i == (count($argv)-1))){
				if(!is_dir($argv[$i])){
					exit('«'.$argv[$i].'» is not a directory.');
				}
				else{
					$infos['workingDir'] = $argv[$i];
					continue;
				}
			}
			
			//Détection des arguments optionnels
			switch($argv[$i]){
				case '--simulate':
					$infos['simulate'] = true;
				break;
				case '--emulate':
					$infos['sql']['options']['emulate'] = true;
				break;
				case '--utf8':
					$infos['sql']['options']['utf8'] = true;
				break;
				case '--driver':
					if((($i+1) == count($argv)) || !(strpos($argv[($i+1)], '--') === false)){
						exit('Invalid driver name.');
					}
					$i++;
					$infos['sql']['options']['driver'] = $argv[$i];
				break;
				case '--keep-ratio':
					$infos['keepRatio'] = true;
				break;
				case '--full-duplicate':
                                        $infos['fullDuplicate'] = true;
				break;
				default:
					exit('Command «'.$argv[$i].'» is not recognized.  Type «help» to see a list of available commands'."\n");
				break;
			}
		}
	}
	
	//Parsage de l'argument principal
	$insIndexer = new Indexer($infos);
	switch($argv[1]){
		case 'help':
			echo 'Here is a list of availables commands for Indexer-cli:'."\n\nMAIN ARGUMENT\n(This argument MUST be the first)\n\n  help    : Show this message\n  index    : Run the indexer script\n  clean-index    : Clean database index\n  clean-thumbs    : Remove unused thumbs\n  mkthumbs    : Generate missing thumbnails\n  checkfiletype    : verify if every file has the correct extention.  If not, the script will correct it.\n\nOPTIONAL ARGUMENTS\nYou can also add these options:\n\n  --emulate     : activate emulated request (if SQL driver doesn't support native prepared statments)\n  --utf8     : Set UTF-8 as default charset for current transaction\n  --driver     : MUST be used with the driver name such as «--driver mysql».  This option allows you to change current driver for database (default: mysql)\n   --simulate     : Do not apply any modification to the index nor files.  Just count the number of files/rows affected by the operation.\n   --keep-ratio     : In case of generating thumbnails, this options ensure your thumbs will not be stretched and image's ratio will be conserved.  Default behaviour is to ignore ration and apply default size\n   --full-duplicate     : Use a query to check if file is duplicate. Otherwise, check is made automatically without a query.  Use this parameter only if you encounter a lot of false duplicates.\n  DIR     : last parameter can be the directory witch will be indexed.  Default is «.»\n\n\nA valid command for indexer-cli can look like this:\n«php indexer-cli.php index --utf8 --driver pgsql /home/user/directoryToIndex»\n";
		break;
		case 'index':
			$insIndexer->index();
		break;
		case 'mkthumbs':
			$insIndexer->mkThumbs();
		break;
		case 'checkfiletype':
			$insIndexer->rewriteTrueType();
		break;
		case 'clean-index': //OPTIMIZED!
			$insIndexer->cleanIndex();
		break;
		case 'clean-thumbs': //OPTIMIZED!
			$insIndexer->cleanThumbs();
		break;
		default:
			exit('Invalid command');
		break;
	}
	
	//Alerte si jamais c'est une simulation
	if($infos['simulate'])
		echo 'WARNING : This was a SIMULATION!  No modification were made!  Run script again without the «--simulate» parameter to apply changes'."\n";
	
	//Classe principale
	class Indexer{
		//Constructeur
		function __construct($infos){
			//Transfert des infos
			$this->infos = $infos;
			//Connexion SQL 
			$this->sqlConnect();
		}
		
		//-----------------------------------
		// Méthodes publiques
		//-----------------------------------
		//Indexe……TOUT o_O
		public function index(){
			if($this->infos['simulate']){
				echo "WARNING : In simulation mode, indexer will NOT detect duplicates files nor showing stats. Do you still want to continue? [Y/n]";
				$reponse = fopen ("php://stdin","r");
				$line = fgets($reponse);
				if(strtolower(trim($line)) != 'y')
					exit("\nOk, we'll do that an other time.\n");
				echo "\n";
				echo "Starting indexation.  We'll keep you informed.\n";
				fclose($reponse);
			}
			//Temps
			$timeStart = microtime(true);
			
			//Préparation des requêtes
			$this->sqlInsertDir['pdo'] = $this->sql->prepare($this->sqlInsertDir['query']);
			$this->sqlInsertDir['pdo']->bindParam(':nom', $this->sqlInsertDir['params']['nom'], PDO::PARAM_STR);
			$this->sqlInsertDir['pdo']->bindParam(':chemin', $this->sqlInsertDir['params']['chemin'], PDO::PARAM_STR);
			$this->sqlInsertDir['pdo']->bindParam(':niveau', $this->sqlInsertDir['params']['niveau'], PDO::PARAM_INT);
			$this->sqlInsertDir['pdo']->bindParam(':parent', $this->sqlInsertDir['params']['parent'], PDO::PARAM_INT);
			$this->sqlInsertFile['pdo'] = $this->sql->prepare($this->sqlInsertFile['query']);
			$this->sqlInsertFile['pdo']->bindParam(':nom', $this->sqlInsertFile['params']['nom'], PDO::PARAM_STR);
			$this->sqlInsertFile['pdo']->bindParam(':mime', $this->sqlInsertFile['params']['mime'], PDO::PARAM_STR);
			$this->sqlInsertFile['pdo']->bindParam(':parent', $this->sqlInsertFile['params']['parent'], PDO::PARAM_INT);
			$this->sqlInsertFile['pdo']->bindParam(':taille', $this->sqlInsertFile['params']['taille'], PDO::PARAM_INT);
			$this->sqlInsertFile['pdo']->bindParam(':largeur', $this->sqlInsertFile['params']['largeur'], PDO::PARAM_INT);
			$this->sqlInsertFile['pdo']->bindParam(':hauteur', $this->sqlInsertFile['params']['hauteur'], PDO::PARAM_INT);
			$this->sqlInsertFile['pdo']->bindParam(':sum', $this->sqlInsertFile['params']['sum'], PDO::PARAM_STR);
			$this->sqlInsertFile['pdo']->bindParam(':type', $this->sqlInsertFile['params']['type'], PDO::PARAM_STR);
			$this->sqlGetDuplicateName['pdo'] = $this->sql->prepare($this->sqlGetDuplicateName['query']);
			$this->sqlGetDuplicateName['pdo']->bindParam(':md5sum', $this->sqlGetDuplicateName['params']['md5sum'], PDO::PARAM_STR);	
			$this->sqlCheckDuplicate['pdo'] = $this->sql->prepare($this->sqlCheckDuplicate['query']);
			$this->sqlCheckDuplicate['pdo']->bindParam(':md5sum', $this->sqlCheckDuplicate['params']['md5sum'], PDO::PARAM_STR);

			//En premier, on récupère la base pour aller plus vite
			$existingFiles = $this->sql->query('SELECT fichiers.id AS id,fichiers.nom AS nom, fichiers.parent AS parent, fichiers.md5sum AS md5sum, dossiers.chemin AS chemin FROM fichiers LEFT JOIN dossiers ON fichiers.parent = dossiers.id');
			while($file = $existingFiles->fetch(PDO::FETCH_ASSOC)){
				$this->indexer['files'][$file['chemin'].'/'.$file['nom']] = array('id' => $file['id'], 'parent' => $file['parent'], 'md5sum' => $file['md5sum']);
			}
			//Et on récupère aussi les dossiers
			$existingDir = $this->sql->query('SELECT id,chemin FROM dossiers');
			while($dossier = $existingDir->fetch(PDO::FETCH_ASSOC)){
				$this->indexer['dir'][$dossier['chemin']] = $dossier['id'];
			}
			$this->indexDir($this->infos['workingDir'], 0, 0);
			
			echo 'Job done!  We\'ve added '.$this->indexer['stats']['dir'].' directories and '.$this->indexer['stats']['files'].' files to the index.'."\n";
			echo 'We\'ve also found '.$this->indexer['stats']['duplicate'].' duplicate files.'."\n";
			$timeStop = microtime(true);
			$totalTime = $timeStop-$timeStart;
			echo 'Indexation took '.round($totalTime, 2).' seconds.'."\n";
			return;
		}
		
		//Indexation des dossiers
		private function indexDir($directory, $niveau, $idParent){
			//Itérateur
			$iterator = new DirectoryIterator($directory);
			foreach($iterator as $fileinfo){
				if($fileinfo->getFilename() == '.' || $fileinfo->getFilename() == '..')
					continue;
				if($fileinfo->isFile()){ //Si c'est un fichier, on l'indexe
					$this->indexFile($fileinfo, $idParent);
				}
				elseif($fileinfo->isDir()){ //Si c'est un dossier, on le traite ici
					if(in_array($fileinfo->getFilename(), $this->infos['ignoredDir']) || (strpos($fileinfo->getFilename(), '.') === 0))
						continue; //On évite les dossiers ignorés
					//On regarde si le dossier est indexé
					$id = 0;
					if(array_key_exists($fileinfo->getPathname(), $this->indexer['dir']))
						$id = $this->indexer['dir'][$fileinfo->getPathname()];
					else{
						if(!$this->infos['simulate']){
							//Le dossier n'existe pas -> on l'ajoute
							$this->sqlInsertDir['params']['chemin'] = $fileinfo->getPathname();
							$this->sqlInsertDir['params']['niveau'] = ($niveau+1);
							$this->sqlInsertDir['params']['nom'] = $fileinfo->getFilename();
							$this->sqlInsertDir['params']['parent'] = $idParent;
							$this->sqlInsertDir['pdo']->execute();
							$id = $this->sql->lastInsertId();echo $id;
							$this->indexer['stats']['dir']++;
						}
					}
					echo 'Visiting «'.$fileinfo->getFilename()."»\n";
					$this->indexDir($fileinfo->getPathname(), ($niveau+1), $id); //Toujours pas de parent
				}
				else
					echo 'WARNING : Unable to visit «'.$fileinfo->getPathname()."».\n";
			}
			//Dossier terminé
			return;
		}
		
		//Indexation des fichiers
		private function indexFile($fileinfo, $idParent){
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			
			//Fichiers invalides ou cachés
			if(strpos($fileinfo->getFilename(), '.') === FALSE || strpos($fileinfo->getFilename(), '.') == 0){
				echo 'INFO : File skipped : '.$fileinfo->getFilename()."\n";
				return;
			}
			//Fichiers volontairement ignorés
			$this->sqlInsertFile['params']['mime'] = finfo_file($finfo, $fileinfo->getPathname());
			if(in_array($this->sqlInsertFile['params']['mime'], $this->infos['ignoredMime'])){
				return;
			}
			//Fichiers existants
			if(array_key_exists($fileinfo->getPathname(), $this->indexer['files']))
				if($this->indexer['files'][$fileinfo->getPathname()]['parent'] == $idParent)
					return;
			//Si on est toujours là, c'est qu'il faut indexer le fichier
			$this->sqlInsertFile['params']['sum'] = md5_file($fileinfo->getPathname());
			//Détection du type de fichier
			if(in_array($this->sqlInsertFile['params']['mime'], $this->mimeImage))
				$this->sqlInsertFile['params']['type'] = 'Photo';
			elseif(in_array($this->sqlInsertFile['params']['mime'], $this->mimeEbooks))
				$this->sqlInsertFile['params']['type'] = 'Ebook';
			elseif(in_array($this->sqlInsertFile['params']['mime'], $this->mimeVideo))
				$this->sqlInsertFile['params']['type'] = 'Video';
			else
				$this->sqlInsertFile['params']['type'] = 'Divers';
			
			//Taille d'image
			if($this->sqlInsertFile['params']['type'] == 'Photo'){
				$taille = getimagesize($fileinfo->getPathname());
				$this->sqlInsertFile['params']['hauteur'] = $taille[1];
				$this->sqlInsertFile['params']['largeur'] = $taille[0];
			}
			else{
				$this->sqlInsertFile['params']['hauteur'] = 0;
				$this->sqlInsertFile['params']['largeur'] = 0;
			}
			if(!$this->infos['simulate']){
				//Bind des autres params 
				$this->sqlInsertFile['params']['nom'] = $fileinfo->getFilename();
				$this->sqlInsertFile['params']['parent'] = $idParent;
				$this->sqlInsertFile['params']['taille'] = $fileinfo->getSize();
				//- - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				//Cette sécurité, à première vue inutile, sert pour les bases PostGRE SQL qui ont l'air d'avoir
				//quelques difficultés avec le rowCount().  Par sécurité, on vérifie «manuellement» si le md5_file
				//est déjà dans la base.  Ça alourdit grandement la procédure (hélàs) mais au moins, le nombre de 
				//faux positifs chute drastiquement.
				//- - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
				if($this->infos['fullDuplicate']){
                                    //Vérification approfondie des doublons
                                    $this->sqlCheckDuplicate['params']['md5sum'] = md5_file($fileinfo->getPathname());
                                    $this->sqlCheckDuplicate['pdo']->execute();
                                    $isExistingFile = $this->sqlCheckDuplicate['pdo']->fetch(PDO::FETCH_ASSOC);
                                    if($isExistingFile === FALSE){
                                        //Pas de doublons!
                                        $this->sqlInsertFile['pdo']->execute();
                                        $this->indexer['stats']['files']++;
                                    }
                                    else{
                                        echo 'WARNING : File «'.$fileinfo->getPathname().'» is detected as duplicate.'."\n";
                                        echo 'Duplicate file is «'.$isExistingFile['chemin'].'/'.$isExistingFile['fichier']."»\n";
                                        $currentDirFull = pathinfo($fileinfo->getPathname());
                                        $currentDir = $currentDirFull['dirname'];
                                        $currentDir = array_pop(explode('/', $currentDir));
                                        if(!is_dir($this->addFinalSlash($this->infos['duplicatePath']).$currentDir)){
                                            mkdir($this->addFinalSlash($this->infos['duplicatePath']).$currentDir);
                                        }
                                        rename($fileinfo->getPathname(), $this->addFinalSlash($this->addFinalSlash($this->infos['duplicatePath']).$currentDir).$fileinfo->getFilename());
                                        $this->indexer['stats']['duplicate']++;
                                    }
				}
				else{
                                    $this->sqlInsertFile['pdo']->execute();
                                    //var_dump($this->sqlInsertFile['pdo']->errorInfo());
                                    
                                    //On vérifie s'il ne s'agit pas d'un doublon
                                    //Check normal des doublons
                                    if($this->sqlInsertFile['pdo']->rowCount() == 0){
                                            echo 'WARNING : File «'.$fileinfo->getPathname().'» is detected as duplicate.'."\n";
                                            $this->sqlGetDuplicateName['params']['md5sum'] = md5_file($fileinfo->getPathname());
                                            $this->sqlGetDuplicateName['pdo']->execute();
                                            $duplicateNameResult = $this->sqlGetDuplicateName['pdo']->fetch(PDO::FETCH_ASSOC);
                                            echo 'Duplicate file is «'.$duplicateNameResult['chemin'].'/'.$duplicateNameResult['nom']."»\n";
                                            rename($fileinfo->getPathname(), $this->addFinalSlash($this->infos['duplicatePath']).$fileinfo->getFilename());
                                            $this->indexer['stats']['duplicate']++;
                                    }
                                    else{
                                            $this->indexer['stats']['files']++;
                                    }
				}
			}
			finfo_close($finfo);
			//Job done! ;)
			return;
		}
		
		//Supprime les fichiers absents de l'index SQL
		public function cleanIndex(){
			$timeStart = microtime(true);
			
			//Préparation des requêtes SQL demandées
			//Sélection des sous-dossiers
			$this->sqlGetSubDirs['pdo'] = $this->sql->prepare($this->sqlGetSubDirs['query']);
			$this->sqlGetSubDirs['pdo']->bindParam(':id', $this->sqlGetSubDirs['params']['id'], PDO::PARAM_INT);
			//Suppression d'un dossier
			$this->sqlDeleteDir['pdo'] = $this->sql->prepare($this->sqlDeleteDir['query']);
			$this->sqlDeleteDir['pdo']->bindParam(':id', $this->sqlDeleteDir['params']['id'], PDO::PARAM_INT);
			//Suppression des fichiers
			$this->sqlDeleteFilesFromDir['pdo'] = $this->sql->prepare($this->sqlDeleteFilesFromDir['query']);
			$this->sqlDeleteFilesFromDir['pdo']->bindParam(':id', $this->sqlDeleteFilesFromDir['params']['id'], PDO::PARAM_INT);
			
			//Variables de fonction
			$nbDir = 0;
			$nbFile = 0;
			$path = $this->addFinalSlash(realpath($this->infos['workingDir']));
			
			//Requêtes préparées
			$deleteFileBindId = 0;
			$deleteFile = $this->sql->prepare('DELETE FROM fichiers WHERE id=:id');
			$deleteFile->bindParam(':id', $deleteFileBindId, PDO::PARAM_INT);
			
			//1)Vérification des dossiers
			$listDir = $this->sql->query('SELECT id,chemin,nom FROM dossiers');
			while($dossier = $listDir->fetch(PDO::FETCH_ASSOC)){
				if(realpath($dossier['chemin']) === FALSE){
					if(!$this->infos['simulate'])
						$this->cleanSubDir($dossier['id']);
					echo 'INFO : Directory «'.$dossier['nom']."» deleted.\n";
					$nbDir++;
				}//Fin «if» dir !exists
			}//Fin «while» liste dossiers
			
			//2)Vérification des fichiers
			$listPictures = $this->sql->query('SELECT fichiers.id,fichiers.nom,fichiers.parent,dossiers.chemin AS chemin FROM fichiers LEFT JOIN dossiers ON fichiers.parent=dossiers.id');
			while($image = $listPictures->fetch(PDO::FETCH_ASSOC)){
				//$actualPath = (strpos($image['chemin'], '.') == 0) ? $path.substr($image['chemin'], 1) : $path.$image['chemin'];
				$actualPath = $this->removeStartingTrash($this->addFinalSlash($image['chemin']));
				if(!is_file($this->addFinalSlash($actualPath).$image['nom'])){
					$deleteFileBindId = $image['id'];
					if(!$this->infos['simulate'])
						$deleteFile->execute();
					echo 'INFO : File «'.$image['nom']."» deleted.\n";
					$nbFile++;
				}
			}
			echo $nbDir.' directories and '.$nbFile.' files were deleted'."\n";
			$timeStop = microtime(true);
			$totalTime = $timeStop-$timeStart;
			echo 'Cleaning database took '.round($totalTime, 2).' seconds.'."\n";
		}
		
		//Supprime les miniatures non utilisées, dans l'index et dans le dossier
		function cleanThumbs(){
			//Temps
			$timeStart = microtime(true);
			
			//Requêtes
			$getHasRecordBindThumb = '';
			$getHasRecord = $this->sql->prepare('SELECT id FROM fichiers WHERE thumbnail=:thumb');
			$getHasRecord->bindParam(':thumb', $getHasRecordBindThumb, PDO::PARAM_STR);
			$updateThumbBindId = 0;
			$updateThumb = $this->sql->prepare('UPDATE fichiers SET thumbnail=\'\' WHERE id=:id');
			$updateThumb->bindParam(':id', $updateThumbBindId, PDO::PARAM_INT);
			
			//Et on y va!
			echo 'First, we\'ll check if every thumb is used.  Let\'s go!'."\n\n";
			
			$arraySql = array();
			$invalidThumbs = array();
			$iterator = new DirectoryIterator($this->infos['thumbsPath']);
			
			//1)On récupère la liste des images dans la base
			$listPictures = $this->sql->query('SELECT id,thumbnail FROM fichiers WHERE thumbnail<>\'\' AND type=\'Photo\'');
			//Transformation en un array plus facile à manipuler
			while($image = $listPictures->fetch(PDO::FETCH_ASSOC)){
				$arraySql[$image['thumbnail']] = $image['id'];
			}
			//2)On vérifie la concordance des deux
			foreach($iterator as $thumb){
				if($thumb->isDir())
					continue;
				if(array_key_exists($thumb->getFilename(), $arraySql))
					unset($arraySql[$thumb->getFilename()]);
				else
					$invalidThumbs[] = $thumb->getFilename();
			}
			//3)On regarde ce qui reste
			//3.1)Des enregistremenst SQL sont invalides
			if(count($arraySql) == 0){
				echo 'Great!  Every record belongs to a valid thumbnail!'."\n";
			}
			else{
				echo 'Uhu?  We\'ve found '.count($arraySql).' record(s) with invalid thumbnail :(.'."\nFixing…\n";
				if(!$this->infos['simulate']){
					foreach($arraySql as $key => $val){
						$updateThumbBindId = intval($val);
						$updateThumb->execute();
					}
				}
				echo "Invalid records fixed, but there are some pictures without thumbnail.  You should run «mkthumbs» to solve this.\n";
			}
			//3.2)Des fichiers sont invalides
			if(count($invalidThumbs) > 0){
				echo 'Oh no! :(  There are '.count($invalidThumbs).' unused thumbnails. :/.'."\nFixing…\n";
				if(!$this->infos['simulate']){
					//Checking path
					$path = $this->addFinalSlash($this->infos['thumbsPath']);
					//Deleting
					foreach($invalidThumbs as $image){
						unlink($path.$image);
					}
				}
				echo "Unused thumbs deleted!\n";
			}
			else{
				echo 'Perfect!  There is no unused thumbs!'."\n";
			}
			
			//On vérifie s'il ne manque pas de miniatures
			$nbMin = $this->sql->query('SELECT COUNT(id) FROM fichiers WHERE thumbnail=\'\' AND type=\'Photo\'');
			$nombre = $nbMin->fetch(PDO::FETCH_NUM);
			if($nombre[0] > 0)
				echo 'Damn!  '.$nombre[0].' pictures havo NO thumbnail!  Run «mkthumbs» to solve this.'."\n";
			
			$timeStop = microtime(true);
			$totalTime = $timeStop-$timeStart;
			echo 'Cleaning thumbs took '.round($totalTime, 2).' seconds.'."\n";
		}
		
		//Génère les mimiatures manquantes
		function mkthumbs(){
			$timeStart = microtime(true);
			
			//Variables de fonction
			$current = 1;
			$nbThumbs = 0;
			
			//Préparation des requêtes utiles
			$updateThumb = $this->sql->prepare('UPDATE fichiers SET thumbnail=:thumb WHERE id=:id');
			$updateThumbBindNom = ''; $updateThumbBindId = 0;
			$updateThumb->bindParam(':thumb', $updateThumbBindNom, PDO::PARAM_STR);
			$updateThumb->bindParam(':id', $updateThumbBindId, PDO::PARAM_INT);
			
			//Requête principale
			$listPictures = $this->sql->query('SELECT fichiers.id,fichiers.nom,fichiers.parent,fichiers.thumbnail,fichiers.mime,fichiers.width,fichiers.height,dossiers.chemin AS chemin FROM fichiers LEFT JOIN dossiers ON fichiers.parent=dossiers.id WHERE fichiers.type=\'Photo\' AND fichiers.thumbnail=\'\'');
			$nombre = $listPictures->rowCount();
			
			//Info for user
			if($nombre > 0)
				echo 'We\'ve found '.$nombre.' missing thumbnails.  Generation started.'."\n";
			
			while($image = $listPictures->fetch(PDO::FETCH_ASSOC)){
				//On retire le «.» initial
				$actualPath = $this->addFinalSlash($this->removeStartingTrash($image['chemin']));

				//Si l'image source n'existe pas, incohérence dans la base
				if(!is_file($actualPath.$image['nom'])){
					exit('FATAL ERROR: file not found: '.$actualPath.$image['nom']."\nRun «clean-index» should solve this problem.\n");
				}
				if(!$this->infos['simulate']){
					$origen;
					if($image['mime'] == 'image/jpeg'){
						$origen = imagecreatefromjpeg($actualPath.$image['nom']);
					}
					elseif($image['mime'] == 'image/png'){
						$origen = imagecreatefrompng($actualPath.$image['nom']);
					}
					elseif($image['mime'] == 'image/vnd.wap.wbmp'){
						$origen = imagecreatefromwbmp($actualPath.$image['nom']);
					}
					elseif($image['mime'] == 'image/gif'){
						$origen = imagecreatefromgif($actualPath.$image['nom']);
					}
					elseif($image['mime'] == 'image/xbm'){
						$origen = imagecreatefromxbm($actualPath.$image['nom']);
					}
					else{
						exit('FATAL ERROR : Unsupported image type: '.$image['mime']);
					}
					//Redimensionnement
					$thumb;
					if(!$this->infos['keepRatio']){
						$thumb = imagecreatetruecolor($this->infos['thumbSize']['width'], $this->infos['thumbSize']['height']);
						imagecopyresized($thumb, $origen, 0, 0, 0, 0, $this->infos['thumbSize']['width'], $this->infos['thumbSize']['height'], $image['width'], $image['height']);
					}
					else{
						$ratio = $this->getRatioSize($image['width'], $image['height']);
						$thumb = imagecreatetruecolor(($image['width']*$ratio), ($image['height']));
						imagecopyresized($thumb, $origen, 0, 0, 0, 0, ($image['width']*$ratio), ($image['height']*$ratio), $image['width'], $image['height']);
					}
					$nom = uniqid().'.jpg';
					$fullName = $this->addFinalSlash($this->infos['thumbsPath']).$nom;
					imagejpeg($thumb, $fullName);
					
					//Insertion en BDD
					$updateThumbBindId = $image['id'];
					$updateThumbBindNom = $nom;
					$updateThumb->execute();
				}
				//Stats pour l'utilisateur
				if(($current%10)==0)
					echo $current.'/'.$nombre."\n";
				$current++;
				$nbThumbs++;
			}
			$timeStop = microtime(true);
			$totalTime = $timeStop-$timeStart;
			if($nombre > 0)
				echo $nbThumbs.' were generated in '.round($totalTime, 2).' seconds.'."\n";
			else
				echo 'Great!  Every file indexed has its own thumb.  Nothing to do.'."\n";
		}
		
		//Corrige l'extention du fichier si nécessaire
		function rewriteTrueType(){
			echo "WARNING : this operation can take a HUGE time (more than 1 hour if you have 200k files). Do you still want to continue? [Y/n]";
			$reponse = fopen ("php://stdin","r");
			$line = fgets($reponse);
			if(strtolower(trim($line)) != 'y')
				exit("\nOk, we'll do that an other time.\n");
			echo "\n";
			echo "Ok.  Let's scan baby (not NSA style, relax :P)\n";
			//Temps
			$timeStart = microtime(true);
			$nbRewrited = 0;
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$correspondances = array('image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif');
			//On a juste besoin des fichiers, donc on utiliser RecursiveDirectoryIterator
			$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->infos['workingDir']), RecursiveIteratorIterator::SELF_FIRST);
			foreach($objects as $name => $object){
				$mime = finfo_file($finfo, $object->getPathname());
				if(array_key_exists($mime, $correspondances)){
					$extension = pathinfo($object->getPathname(), PATHINFO_EXTENSION);
					if($correspondances[$mime] != strtolower($extension)){
						if($mime == 'image/jpeg'){
							if(strtolower($extension) == 'jpeg')
								continue;
						}
						//Si on est ici, c'est qu'il faut renommer le fichier
						$nomFichier = pathinfo($object->getPathname(), PATHINFO_FILENAME);
						$nomDossier = pathinfo($object->getPathname(), PATHINFO_DIRNAME);
						if(!$this->infos['simulate'])
							rename($object->getPathname(), $this->addFinalSlash($nomDossier).$nomFichier.'.'.$correspondances[$mime]);
						$nbRewrited++;
						echo 'WARNING : File «'.$object->getPathname().'» has an incorrect extention.  Correct is «'.$mime."»\n";
					}
				}
			}
			$timeStop = microtime(true);
			$totalTime = $timeStop-$timeStart;
			echo 'Job done.  We\'ve found '.$nbRewrited." incorrect files\n";
			echo 'This seach took '.round($totalTime, 2).' seconds.'."\n";
		}
		
		//-----------------------------------
		// Méthodes privées
		//-----------------------------------
		private function sqlConnect(){
			$base = $this->infos['sql']['options']['driver'].':dbname='.$this->infos['sql']['base'].';host='.$this->infos['sql']['server'];
			try{
				$this->sql = new PDO($base, $this->infos['sql']['user'], $this->infos['sql']['pass']);
			} 
			catch (PDOException $e) {
				exit('Connection failed : ' . $e->getMessage());
			}
			//Application des demandes de l'utilisateur
			if(!$this->infos['sql']['options']['emulate'])//Pas d'émulation des requêtes préparées
				$this->sql->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
			if($this->infos['sql']['options']['utf8'])
				$this->sql->query('SET NAMES \'utf8\'');
			return true;
		}
		
		//Ajoute un «/» final aux chemins
		private function addFinalSlash($path){
			$fixedPath = $path;
			if(strrpos($path, '/') != (strlen($path)-1)){
				$fixedPath .= '/';
			}
			if($path == '.')
				$fixedPath .= '/';
			return $fixedPath;
		}
		
		//Retire les «scories» devant le chemin
		private function removeStartingTrash($path){
			$nvPath = $path;
			if(strpos($nvPath, '.') === 0){
				$nvPath = substr($nvPath, 1);
			}
			if(strpos($nvPath, '/') === 0){
				$nvPath = substr($nvPath, 1);
			}
			return $nvPath;
		}
		
		//Nettoie un sous-dossier
		function cleanSubDir($idDir){
			//1)Suppression du dossier
			$this->sqlDeleteDir['params']['id'] = $idDir;
			$this->sqlDeleteDir['pdo']->execute();
			//2)Suppression des fichiers contenus dans le dossier
			$this->sqlDeleteFilesFromDir['params']['id'] = $idDir;
			$this->sqlDeleteFilesFromDir['pdo']->execute();
			//3)Listage des sous-dossiers
			$this->sqlGetSubDirs['params']['id'] = $idDir;
			$this->sqlGetSubDirs['pdo']->execute();
			$listeSubDirs = $this->sqlGetSubDirs['pdo']->fetchAll(PDO::FETCH_ASSOC);
			foreach($listeSubDirs as $dir){
				//Nettoyage récursif des sous-dossiers
				$this->cleanSubDir($dir['id']);
			}
			return;
		}
		
		//Renvoie le ratio à appliquer pour les miniatures
		function getRatioSize($width, $height){
			$ratioWidth = $width/$this->infos['thumbSize']['width'];
			$ratioHeight = $height/$this->infos['thumbSize']['height'];
			return ($ratioWidth > $ratioHeight) ? $ratioWidth : $ratioHeight;
		}
		
		//-----------------------------------
		// Attributs de classe
		//-----------------------------------
		//Divers
		private $infos;
		private $sql;
		private $indexer = array('files' => array(), 'dir' => array(), 'stats' => array('files' => 0, 'dir' => 0, 'duplicate' => 0));
		//Mimes
		private $mimeImage = array('image/gif', 'image/jpeg', 'image/png', 'image/psd', 'image/bmp', 'image/tiff', 'image/jp2', 'image/iff', 'image/vnd.wap.wbmp', 'image/xbm', 'image/vnd.microsoft.icon');
		private $mimeVideo = array('video/1d-interleaved-parityfec','video/3gpp','video/3gpp2','video/3gpp-tt','video/BMPEG','video/BT656','video/CelB','video/DV','video/encaprtp','video/example','video/H261','video/H263','video/H263-1998','video/H263-2000','video/H264','video/H264-RCDO','video/H264-SVC','video/iso.segment','video/JPEG','video/jpeg2000','video/mj2','video/MP1S','video/MP2P','video/MP2T','video/mp4','video/MP4V-ES','video/MPV','video/mpeg4-generic','video/nv','video/ogg','video/pointer','video/quicktime','video/raptorfec','video/rtp-enc-aescm128','video/rtploopback','video/rtx','video/SMPTE292M','video/ulpfec','video/vc1','video/vnd.CCTV','video/vnd.dece.hd','video/vnd.dece.mobile','video/vnd.dece-mp4','video/vnd.dece.pd','video/vnd.dece.sd','video/vnd.dece.video','video/vnd.directv-mpeg','video/vnd.directv.mpeg-tts','video/vnd.dlna.mpeg-tts','video/vnd.dvb.file','video/vnd.fvt','video/vnd.hns.video','video/vnd.iptvforum.1dparityfec-1010','video/vnd.iptvforum.1dparityfec-2005','video/vnd.iptvforum.2dparityfec-1010','video/vnd.iptvforum.2dparityfec-2005','video/vnd.iptvforum.ttsavc','video/vnd.iptvforum.ttsmpeg2','video/vnd.motorola.video','video/vnd.motorola.videop','video/vnd-mpegurl','video/vnd.ms-playready.media.pyv','video/vnd.nokia.interleaved-multimedia','video/vnd.nokia.videovoip','video/vnd.objectvideo','video/vnd.radgamettools.bink','video/vnd.radgamettools.smacker','video/vnd.sealed.mpeg1','video/vnd.sealed.mpeg4','video/vnd.sealed-swf','video/vnd.sealedmedia.softseal-mov','video/vnd.uvvu-mp4','video/vnd-vivo');
		private $mimeEbooks = array('application/zip','application/epub+zip','application/x-mobipocket-ebook','application/x-mobipocket','application/pdf','application/x-rar');
		//REQUÊTES GLOBALES
		private $sqlGetSubDirs = array('query' => 'SELECT id FROM dossiers WHERE parent=:id', 'params' => array('id' => 0));
		private $sqlDeleteDir = array('query' => 'DELETE FROM dossiers WHERE id=:id', 'params' => array('id' => 0));
		private $sqlDeleteFilesFromDir = array('query' => 'DELETE FROM fichiers WHERE parent=:id', 'params' => array('id' => 0));
		private $sqlCheckDuplicate = array('query' => 'SELECT dossiers.nom AS dossier, dossiers.chemin AS chemin, fichiers.nom AS fichier FROM fichiers LEFT JOIN dossiers ON fichiers.parent=dossiers.id WHERE fichiers.md5sum=:md5sum', 'params' => array('md5sum' => ''));
		private $sqlGetDuplicateName = array('query' => 'SELECT fichiers.nom AS nom,dossiers.chemin AS chemin FROM fichiers LEFT JOIN dossiers ON fichiers.parent = dossiers.id WHERE fichiers.md5sum = :md5sum', 'params' => array('md5sum' => ''));
		private $sqlInsertDir = array('query' => 'INSERT INTO dossiers(nom, chemin, niveau, parent) VALUES (:nom, :chemin, :niveau, :parent)', 'params' => array('nom' => '', 'chemin' => '', 'niveau' => 0, 'parent' => ''));
		private $sqlInsertFile = array('query' => 'INSERT INTO fichiers(nom, mime, parent, size, width, height, md5sum, type) VALUES (:nom, :mime, :parent, :taille, :largeur, :hauteur, :sum, :type)', 'params' => array('nom' => '', 'mime' => '', 'parent' => 0, 'taille' => 0, 'sum' => '', 'largeur' => 0, 'hauteur' => 0, 'type' => ''));
	}
?>
