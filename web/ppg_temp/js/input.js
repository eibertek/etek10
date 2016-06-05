/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var input = { 
        key_a:65,
        key_b:66,
        key_c:67,
        key_d:68,
        key_e:69,
        key_f:70,
        key_g:71,
        key_h:72,
        key_i:73,
        key_j:74,        
        key_k:75,        
        key_l:76,        
        key_m:77,        
        key_n:78,        
        key_o:79,        
        key_p:80,        
        key_q:81,        
        key_r:82,        
        key_s:83,        
        key_t:84,        
        key_u:85,        
        key_v:86,        
        key_w:87,        
        key_x:88,        
        key_y:89,        
        key_z:90,        
        key_left:37,        
        key_up:38,        
        key_right:39,        
        key_down:40,        
        key_space:32,        
        key_enter:13,
        key_backspace:8,
        key_F3: 114,
        key_F4: 115,
        key_F5: 116,
        prevent_default:false,
        key_code:-1,
        key_press:'',
        onKeyDown: function(event, preventDefault){
            this.prevent_default = preventDefault ? true : false;
            this.key_code = event.keyCode;
            if(this.prevent_default && this.key_code < 114)   event.preventDefault();            
            this.key_press = this.toKeyString();
            return true;
        },
        onKeyUp: function(event){
            this.key_code = event.keyCode;
            this.key_press = this.toKeyString();
            return true;
        },        
        toKeyString: function(){
            switch(this.key_code){
                case this.key_left:
                        return 'LEFT';
                case this.key_up:
                        return 'UP';
                case this.key_down:
                        return 'DOWN';
                case this.key_right:
                        return 'RIGHT';
                case this.key_space:
                        return 'SPACE';
                case this.key_enter:
                        return 'ENTER';
                case this.key_backspace:
                        return 'BACKSPACE';                        
                default:   
                        return String.fromCharCode(this.key_code);
            }
        }
}

/*window.addEventListener("keydown", 
                        function(event) {
                            input.onKeyDown(event, true);
                            var key_code = input.key_code;
                            var key_press = input.key_press;
                            document.getElementById('kp').innerHTML = key_press;
                            document.getElementById('kc').innerHTML = key_code;
                            var status = document.getElementById('status');
                            var log = document.getElementById('keylog');
                            status.innerHTML= "DOWN Event Fired For : "+key_press;
                            log.innerHTML+= "<br/>Key : "+key_press+"("+key_code+")";
                        }, false);
window.onkeyup = function(event){
        input.onKeyUp(event);
        var key_code = input.key_code;
        var key_press = input.key_press;
	status.innerHTML = "UP Event Fired For : "+key_press;
}
*/

