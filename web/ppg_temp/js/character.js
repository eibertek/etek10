/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var player = function(data){
    this.name   = '';
    this.ia     = false;
    this.life   = 0;
    this.attack = 0;
    this.defense = 0;
    this.image  = '';
    this.status = null;
    this.color = '#0000'
    this.position= new canvas.vector(0,0);
    this.width = 0;
    this.height = 0;
    this.moveTo = function(x,y){
        this.position.x = x;
        this.position.y = y;
    };
    this.create = function(data){
        if(typeof(data.ia) != "undefined")
            this.ia=data.ia?true:false;
        if(typeof(data.name) != "undefined")
            this.name=data.name;
        if(typeof(data.x) != "undefined")
            this.position.x=data.x;        
        if(typeof(data.y) != "undefined")
            this.position.y=data.y;                
        if(typeof(data.color) != "undefined")
            this.color=data.color;                
        
    };
    this.create(data);
}


