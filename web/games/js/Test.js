/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
        var $div = $("<div>", {id: "foo", class: "card_element"});
        $div.click(function(){ /* ... */ });
        $("#game_canvas").append($div);
        var orientation="+";
        move= function(){
           leftobj = $div.offset().left+$div.width();     
           console.log(leftobj,$div.parent().width(), orientation);           
            if(
              ( leftobj > $div.parent().width()-25 &&              
              leftobj < $div.parent().width()+25) ||
              $div.offset().left  < $div.parent().offset().left + 20
              ){
             changeOrientation();
           }
           $div.stop().animate({ left: orientation+'=50px'});           
        }
        
        changeOrientation= function(){
            if(orientation=="+") 
                orientation="-" 
            else 
                orientation="+";
        }
  //      setInterval(move,500);


