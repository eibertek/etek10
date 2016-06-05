
canvas.init();
var object = function(img, gravity, position, width, height, bounds){
    this.img = '';
    this.gravity= true;
    this.position= new canvas.vector(0,0);
    this.width = 0;
    this.height = 0;
    this.bounds = [];
    this.create = function(img, gravity, position, width, height, bounds){
            if( typeof(img) != "undefined" ){
                this.img= img;
            }
            if( typeof(gravity) != "undefined" ){
                this.gravity= gravity;
            }
            if( typeof(position) != "undefined"  && position instanceof canvas.vector ){
                this.position= position;
            }
            if( typeof(width) != "undefined" ){
                this.width= width;
            }
            if( typeof(height) != "undefined" ){
                this.height= height;
            }
            if( typeof(bounds) != "undefined" && bounds instanceof bound){
                this.setBound(bounds);
            }else{
                this.setBound(new bound(this.position.x,this.position.y, this.position.x+this.width, this.position.y+this.height, false) );
            }
    };
    this.setBound = function(bound){
        this.bounds.push(bound);
    };
    this.collide = function(object){
        //collide x
        if( ( object.position.x > this.position.x && object.position.x < this.position.x+ this.width) 
            && ( object.position.y > this.position.y && object.position.y < this.position.y+ this.height) ){
                return true;
            }else{
                return false;
            }
    };
    this.animate = function(status){
        switch(status){
            case 1:
                //animate Idle
                break;
            case 2:
                // animate attack;
                break;
            case 3:
                // animate attacked
                break;
            case 4:
                // animate destroyed
                break;
            default:
                //animate Idle
                if(this.img ==''){
                   canvas.drawRect(this.position, this.width, this.height,{color:'#0000DD'});                    
                }
                break;
        }
    };
    this.create(img, gravity, position, width, height, bounds);
};
var bound = function(originX, originY, destX, destY, ethereal){
    this.originX = 0;
    this.originY = 0;
    this.destX = 0;
    this.destY = 0;
    this.ethereal = false;
    this.is_ethereal = function(){
        return this.ethereal;
    }
    this.create = function(originX, originY, destX, destY, ethereal){
        this.originX = originX;
        this.originY = originY;
        this.destX = destX;
        this.destY = destY;
        this.ethereal = ethereal;
        return this;
    };
    return this.create(originX, originY, destX, destY, ethereal);
};

var game = {
    date: new Date(),
    phisics: {gravity:9.8},
    players: new Array(),
    objects: new Array(),
    worldBounds: [],
    render: function(){
//        canvas.ctx.drawImage(fondo, 0,0, canvas.container.width, canvas.container.height);
        canvas.drawLine(new canvas.vector(canvas.container.width-10,0),
                        new canvas.vector(canvas.container.width-10,canvas.container.height),
                        {color:'#CCCCCC'});
        for(var c=0; c < this.objects.length; c++ ){
            if(this.objects[c].gravity 
                && ( this.objects[c].position.y+this.objects[c].height < canvas.container.height-10)
                ){
                this.objects[c].position.y+=this.phisics.gravity;
            }
            this.objects[c].animate();                
        }    
        for(var c=0; c < this.players.length; c++ ){

        }                
    },
    addPlayer: function(player){
        this.players.push(player);
    },
    addObject: function(object){
        this.objects.push(object);
    },
    addBound: function(bound){
        this.worldBounds.push(bound);
    }
    
};
game.addPlayer(new player({name:'Player 1', x:10, y:200, color:'#FF0000'}));
game.addObject(new object('',false, new canvas.vector(30,30),40,50));
game.addBound(new bound(0,canvas.container.height-10, canvas.container.width, canvas.container.height-10, false));
counter=3;
function renderize(){
    canvas.ctx.clearRect(0, 0, canvas.container.width, canvas.container.height);        
    game.render();
}
function startGame(){
        window.addEventListener("keydown", 
                                function(event) {
                                    input.onKeyDown(event, true);
                                    if(input.key_code == input.key_right || input.key_code == input.key_d){
                                        game.players[0].position.x+=10;
                                    }
                                    if(input.key_code == input.key_left || input.key_code == input.key_a){
                                        game.players[0].position.x-=10;
                                    }
                                    if(input.key_code == input.key_up || input.key_code == input.key_w){
                                        game.players[0].position.y-=10;
                                    }
                                    if(input.key_code == input.key_down || input.key_code == input.key_s){
                                        game.players[0].position.y+=10;
                                    }                                    
        }, false);
        canvas.ctx.clearRect(0, 0, canvas.container.width, canvas.container.height);        
        window.setInterval(renderize,100);
/*        canvas.drawText(counter,{color:'#000'});
        counter--;
        if(counter==0){
            canvas.ctx.clearRect(0, 0, canvas.container.width, canvas.container.height);        
            canvas.drawText('Start!!!',{color:'#000'});
            setTimeout(function(){
                game.render();
                window.setInterval(race,10);
            }, 1000);            
        }else{
            setTimeout(startGame, 1000);            
        }
        */
}

function finishGame(winner){
            canvas.ctx.clearRect(0, 0, canvas.container.width, canvas.container.height);        
            canvas.drawText('Finish!!',{color:'#000', x:canvas.container.width/3});
            canvas.drawText('Winner:'+winner.name,{color:winner.color, x:canvas.container.width/3, y:canvas.container.height/2+50});
}

//Start Game!!!
startGame();


/*
function race(){
    canvas.ctx.clearRect(0, 0, canvas.container.width, canvas.container.height);        
    for(var c=0; c < game.players.length; c++){
        if(game.players[c].ia === true){
            game.players[c].position.x+= Math.random()*Math.PI;
        }
        if(game.players[c].position.x+20 > game.finishLineX) {
            window.clearInterval('race');
            window.removeEventListener('keydown', function(){});
            finishGame(game.players[c]);
            return true;
        }
    }
    game.render();
}
*/
