<?php

                function ExceptionHandle(Throwable $e, $pageMessage){
					/* Journalisation (Logging) */
						// si une exception est levée
						    error_log("[" . $pageMessage . "] ".$e->getMessage()." dans ".$e->getFile()." , ligne ".$e->getLine());
						// si les en-têtes http sont déjà envoyés
					if (headers_sent($file, $line)) {
						error_log("En-têtes déjà envoyés dans $file à la ligne $line");
					}
						// redirection PHP (si les en-têtes http ne sont pas déjà envoyés)
					if (!headers_sent()) {
						header("Location: index.php?page=$catchPage");
						exit;
					}
						// message si c’est trop tard pour rediriger
						echo "$pageMessage : " . htmlspecialchars($e->getMessage());	
					}

?>