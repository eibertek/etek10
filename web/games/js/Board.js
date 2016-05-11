/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Player = function(name, is_IA){
    this.name = name;
    this.life = 20000;
    this.points = 0;
    this.IA = null;
    this.playerId = name + Math.floor(Math.random() * 6000)
    this.playerclass = "player"+playerNumber.toString();
    this.canvasPlayer = ".gameplace."+this.playerclass;    
    this.playerNumber = playerNumber;
    this.deck = {};
    this.cementery = {};
    this.hand = {};
    var self = this;
    this.initPlayer = function(is_IA){
        if(is_IA)
            this.IA = is_IA;
        this.deck = new Deck(this,'normal');
        $(this.canvasPlayer).width($gamecanvaswidth/2);      
        this.initShadowAcards();  
        this.dealCards();
/*        $(this.canvasPlayer).mousemove(function(event){
            console.log($(self.canvasPlayer).position());
           // console.log('Moviendo mouse ('+event.pageX + ', ' + event.pageY+')',self.playerId);
        });  
        */
        playerNumber++;
    };
    this.initShadowAcards = function(){
        for(var nn=1; nn<6; nn++){
            cardName = "Acard"+nn;
            spawnCardClassNames = "spawnAcard spawn"+cardName+" "+this.playerclass;
            spawnCardClasses = ".spawn"+cardName+"."+this.playerclass;
            var spawnAcard = $("<div>", {class: "card_element spawn "+spawnCardClassNames});
            $(this.canvasPlayer).append(spawnAcard);
            $(spawnCardClasses).css(this.getPosition(cardName));
        }
        cardName = "cementery";
        spawnCardClassNames = "spawnAcard spawn"+cardName+" "+this.playerclass;
        spawnCardClasses = ".spawn"+cardName+"."+this.playerclass;
        var spawnAcard = $("<div>", {class: "card_element spawn "+spawnCardClassNames});
        $(this.canvasPlayer).append(spawnAcard);
        $(spawnCardClasses).css(this.getPosition(cardName));        
    };    
    this.dealCards = function(){
        self.hand = this.deck.getCard(5);
        for(var nn=0; nn<5; nn++){
                card = self.hand[nn];
                cardName="Hcard"+nn;
                spawnCardClassNames = "spawnHcard spawn"+cardName+" "+this.playerclass;
                spawnCardClasses = ".spawn"+cardName+"."+this.playerclass;
                var spawnHcard = $("<div>", {id:card.cardId,class: "card_element spawn "+spawnCardClassNames});
                $(this.canvasPlayer).append(spawnHcard);
                $(spawnCardClasses).css(this.getPosition(cardName));
                $(spawnCardClasses).draggable({ zIndex: 10000, 
                                                containment: self.canvasPlayer,
                                                stop: function() {
                                                    selfId = $(this).attr('id');
                                                    $('.spawnHcard.'+self.playerclass).each(function(){
                                                        var currentElement = $(this);
                                                        if(currentElement.attr('id')!=selfId){
                                                            currentElement.css({ zIndex: 1000});
                                                            console.log(' todos los otros corregido! :)');
                                                        }else{
                                                            currentElement.css({ zIndex: 10000});
                                                            console.log(selfId + ' corregido! :)');

                                                        }
                                                        
                                                    });
                                                  } 
                                              });
        }
        // var $div = $("<div>", {id: this.deckId, class: "deck ui-widget-content"});
        //$("#"+this.deckId).draggable();
    };
    this.getPosition = function(card){
        var positions = {top:null, left:null};
        if(card.indexOf("Acard")!==-1){
            if(this.playerNumber==1){
                positions.left = $(this.canvasPlayer).width() - 100;
            }else{
                positions.left = 20;            
            }
        }
        if(card.indexOf("Hcard")!==-1){
            if(this.playerNumber==1){
                positions.left = 30;
            }else{
                positions.left = $(this.canvasPlayer).width() - 100;            
            }
        }
        switch (card){
            case 'Acard1':
                positions.top = 40;
                break;
            case 'Acard2':
                positions.top = 40+110 ;
                break;
            case 'Acard3':
                positions.top = 40+220 ;                
                break;
            case 'Acard4':
                positions.top = 40 +330;                
                break;
            case 'Acard5':
                positions.top = 40 +440;                
                break;
            case 'Hcard0':
                positions.top = 140;
                break;
            case 'Hcard1':
                positions.top = 140+50 ;
                break;
            case 'Hcard2':
                positions.top = 140+100 ;                
                break;
            case 'Hcard3':
                positions.top = 140 +150;                
                break;
            case 'Hcard4':
                positions.top = 140 +200;                
                break;                
            case 'cementery':
                if(this.playerNumber==1){
                    positions.left = 20;
                    positions.top = $(this.canvasPlayer).height() - 120;                                    
                }else{
                    positions.left = $(this.canvasPlayer).width() - 120;            
                    positions.top = 30;                
                }                
                break;                
            default :    
                break;
        }
    //    console.log(this.playerNumber, positions);
        return positions;
    };
    this.initPlayer(is_IA);
    return this;
}

Card = function(card,deckId){
    this.cardName ="";
    this.cardId ="";
    this.cardStats = {};
    this.status = null;
    this.deckId=null;
    this.position={ top:null, left:null};
    this.initCard = function(card, deckId){
        this.cardName = card.name;
        this.cardId = card.cardId;
        this.status = card.status;
        this.cardStats = { 
            attack: card.attack,
            defense: card.defense,
            life: card.life            
        }
        this.deckId = deckId;
    }
    this.moveCardTo = function(){}
    this.ActionCard = function(){}
    this.AttackTo = function(CardId){}
    
    this.initCard(card, deckId);
    return this;
}

Deck = function(player, deck_type){
    this.deckType = deck_type;
    this.player = player;
    this.deck = [];
    this.deckId = 'Deck_' + Math.floor(Math.random() * 600000);
    this.initDeck = function() {
        console.log('generando Mazo para ' + this.player.playerId);
        for(var c=0; c< $mockDb.length; c++){
            this.addCard(new Card($mockDb[c], this.deckId));
        }    
        this.drawDeck();
    }    
    this.addCard = function(card){
        this.deck.push(card);
    }
    this.drawDeck = function(){
        // hay que agregar coordenadas para cada player.
        var spawnDeck = $("<div>", {class: "card_element deck spawn spawndeck "+this.player.playerclass});
        $(this.player.canvasPlayer).append(spawnDeck);
    }
    this.getCard = function(quantity){
        if(quantity){
            hand = [];
            for(var c=0;c<quantity;c++)
            {
                hand.push(this.deck.shift());
            }
            return hand;
        }else{
            return this.deck.shift();
        }
    }
    this.initDeck();
    return this;
}
var playerNumber=1;
Board = function(){
    this.game = "Batalla!";
    this.boardCanvas = "#game_canvas";
    this.player1={};
    this.player2={};
    this.turn = null;
    this.step = null;
    this.initGame = function(player1, player2) {
        this.Player1 = player1;
        this.Player2 = player2;
       /*Colocar en su lugar:
        * gameplace player1, gameplace player2
        * SpawnDeck1, SpawnDeck2, SpawnCementery1 SpawnCementery2
        * ACard1_1,ACard1_2,ACard1_3,ACard1_4,ACard1_5
        * ACard2_1,ACard2_2,ACard2_3,ACard2_4,ACard2_5
        * PasiveCardDeck1 PasiveCardDeck2
        * */
    }
    this.initGame(new Player("Mariano", false), new Player("Computer", true));
    return this;
}

var $gamecanvaswidth = 0;
var $gamecanvasheight = 0;
window.onload = function(){
    $("#game_canvas").width($('#container').width()-100);
    $("#game_canvas").height($('#container').height());
    $gamecanvaswidth = $("#game_canvas").width();
    $gamecanvasheight = $("#game_canvas").height();
}

