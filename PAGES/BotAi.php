<?php
    require_once('AzureTextAnalytics.php');

    function controlla_presenza_caso($string){
        $f= fopen('../FILE/indexed_word.json', 'r');
        $casi= json_decode(fread($f, filesize('../FILE/indexed_word.json')));
        fclose($f);
        
        foreach($casi as $numero => $caso){
            foreach($caso as $campi => $contenuto){
                if($campi=== 'word' && $contenuto===$string)
                    return true;
            }
        }
        return false;
    }

    function write_word($string, $message){
        $file_name= '../FILE/indexed_word.json';
        if(is_file($file_name)){
            if(controlla_presenza_caso($string)){
            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $f= fopen('../FILE/indexed_word.json', 'r');
                $casi= json_decode(fread($f, filesize('../FILE/indexed_word.json')));
                fclose($f);
                $nuovi_casi= [];
                foreach($casi as $numero => $caso){
                    foreach($caso as $campi => $contenuto){
                        if(($campi==='word' || $campi=='cont') && $contenuto===$string){
                            if($caso!=$prec){
                                foreach($caso as $campi1 => $contenuto1){
                                    if($campi1==='word')
                                        $word_temp= $contenuto1;
                                    else if($campi1==='cont')
                                        $cont_temp= $contenuto1;
                                    else 
                                        $string_temp= $contenuto1. ' <-> '. $message; 
                                }
                                $nuovi_casi[]= [
                                    'word' => $word_temp,
                                    'cont' => $cont_temp+1,
                                    'messaggi' => $string_temp
                                ];
                            }
                            $prec= $caso;
                         }
                        else
                            if($caso!=$prec)
                                $nuovi_casi[]= $caso; 
                    }
                }
                $f= fopen('../FILE/indexed_word.json', 'w');
                fwrite($f, json_encode($nuovi_casi, JSON_PRETTY_PRINT));
                fclose($f);

            }
            else{
                //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                $f= fopen('../FILE/indexed_word.json', 'r');
                $casi= json_decode(fread($f, filesize('../FILE/indexed_word.json')));
                fclose($f);
                $casi[]= [
                    'word' => $string,
                    'cont' => 1,
                    'messaggi'=> $message
                ]; 
                $f= fopen('../FILE/indexed_word.json', 'w');
                fwrite($f, json_encode($casi, JSON_PRETTY_PRINT));
                fclose($f);
            }
        }
        else{
            $f= fopen($file_name, 'w');
            $list[]= [
                'word' => $string,
                'cont' => 1,
                'messaggi' => $message
            ];
            fwrite($f, json_encode($list), JSON_PRETTY_PRINT);
            fclose($f);
        }
    }

    function indexer($message){
        $analytics= scan_message($message);
        write_word($analytics, $message);
    }

    function get_bot_message($message, $option){
        switch($option){
            case 1:
                $f= fopen('../FILE/BotAI.json', 'r');
                $list_cases= json_decode(fread($f, filesize('../FILE/BotAI.json')), true);
                $flag= false;
                foreach($list_cases as $punt => $case){
                    if(strpos(strtolower($message), strtolower($case['tag']))!==false){
                        return $case['answer'];
                        $flag= true;
                    }
                }
                if(!$flag){
                    indexer($message);
                    return "Scusa, non ho capito";
                }
            break;
        }
    }
?>