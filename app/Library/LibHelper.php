<?php
namespace App\Library;
class LibHelper {
    static function skillsFit($skills, $search){
        $search = str_replace('(', ' ', strtolower($search));
        $search = str_replace(')', ' ', strtolower($search));
        $search = str_replace(' and ', ' ', strtolower($search));
        $search = str_replace(' or ', ' ', strtolower($search));
        $search = str_replace('  ', ' ', strtolower($search));
        $search = explode(' ',strtolower($search));

        $skillsArray = [];
        foreach($skills as $s){
            $skillsArray[] = strtolower($s->skill);
        }
        $fit = 0;
        $total = 0;
        foreach($search as $s){
            if($s!=null && $s!=" "){
                $total++;
//                foreach($skillsArray as $skill){
//                    if (strpos(strtolower($skill), strtolower(str_replace('-', ' ', $s))) !== false) {
//                        $fit++;
//                    }
//                }
                if(in_array(strtolower(str_replace('-', ' ', $s)), $skillsArray)){
                    $fit++;
                }
            }
        }
        if($fit>0){
            $fitPercentage = ($fit/$total)*100;
            if($fitPercentage>100){
                return 100;
            }
            return (int)$fitPercentage;
        }else{
            return 0;
        }
    }

}
