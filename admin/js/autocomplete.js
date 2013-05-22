// aggiunge la classe "current" al nodo di nome oSuggestionNode e toglie la classe al nodo vecchio
AutoSuggestControl.prototype.highlightSuggestion = function (oSuggestionNode) {

    for (var i=0; i < this.layer.childNodes.length; i++) {
        var oNode = this.layer.childNodes[i];
        if (oNode == oSuggestionNode) {
            oNode.className = "current"
        } else if (oNode.className == "current") {
            oNode.className = "";
        }
    }
};
      
// cambia lo stile del layer a "hidden"
AutoSuggestControl.prototype.hideSuggestions = function () {
    this.layer.style.visibility = "hidden";
};   


// funzione che crea un elemento div nel document di classe "suggestion" e lo crea "hidden" e della stessa larghezza della textBox
// inoltre gestisce gli eventi del mouse sulla lista
AutoSuggestControl.prototype.createDropDown = function () {

    this.layer = document.createElement("div");
    this.layer.className = "suggestions";
    this.layer.style.visibility = "hidden";
    this.layer.style.width = this.textbox.offsetWidth;
    document.body.appendChild(this.layer);

    // gestione mouse
    var oThis = this;

    this.layer.onmousedown = this.layer.onmouseup =
    this.layer.onmouseover = function (oEvent) {
        oEvent = oEvent || window.event;
        oTarget = oEvent.target || oEvent.srcElement;

        if (oEvent.type == "mousedown") {
            oThis.textbox.value = oTarget.firstChild.nodeValue;
            oThis.hideSuggestions();
        } else if (oEvent.type == "mouseover") {
            oThis.highlightSuggestion(oTarget);
        } else { // mouseup
            oThis.textbox.focus();
        }
    };
};

// funzione che calcola la distanza dal bordo sinistro della pagina del textBox, prendendo per ogni nodo della pagina, la distanza dal nodo padre, fino al nodo body
AutoSuggestControl.prototype.getLeft = function () {

    var oNode = this.textbox;
    var iLeft = 0;

    while(oNode.tagName != "BODY") {
        iLeft += oNode.offsetLeft;
        oNode = oNode.offsetParent;
    }

    return iLeft;
};

// idem come sopra
AutoSuggestControl.prototype.getTop = function () {

    var oNode = this.textbox;
    var iTop = 0;

    while(oNode.tagName != "BODY") {
        iTop += oNode.offsetTop;
        oNode = oNode.offsetParent;
    }

    return iTop;
};

// funzione che accetta una lista di suggerimenti e li mostra nel layer, in pratica crea un div dentro a layer per ogni suggerimento e ci scrive dentro la parola
AutoSuggestControl.prototype.showSuggestions = function (aSuggestions) {
    var oDiv = null;
    this.layer.innerHTML = "";
	
    for (var i=0; i < aSuggestions.length; i++) {
	
        oDiv = document.createElement("div");
        oDiv.appendChild(document.createTextNode(aSuggestions[i]));
        this.layer.appendChild(oDiv);
    }

    this.layer.style.left = this.getLeft() + "px";
    this.layer.style.top = (this.getTop()+this.textbox.offsetHeight) + "px";
    this.layer.style.visibility = "visible";
};

AutoSuggestControl.prototype.nextSuggestion = function () {
    var cSuggestionNodes = this.layer.childNodes;

    if (cSuggestionNodes.length > 0 && this.cur < cSuggestionNodes.length-1) {
        var oNode = cSuggestionNodes[++this.cur];
        this.highlightSuggestion(oNode);
        this.textbox.value = oNode.firstChild.nodeValue;
    }
};

AutoSuggestControl.prototype.previousSuggestion = function () {
    var cSuggestionNodes = this.layer.childNodes;

    if (cSuggestionNodes.length > 0 && this.cur > 0) {
        var oNode = cSuggestionNodes[--this.cur];
        this.highlightSuggestion(oNode);
        this.textbox.value = oNode.firstChild.nodeValue;
    }
};

// funzione che verrà bindata per gestire gli eventi key arrow
AutoSuggestControl.prototype.handleKeyDown = function (oEvent) {
    switch(oEvent.keyCode) {
        case 38: //up arrow
            this.previousSuggestion();
            break;
        case 40: //down arrow
            this.nextSuggestion();
            break;
        case 13: //enter
            this.hideSuggestions();
            break;
    }
};

       
//Definizione della classe AutoSuggestControl
function AutoSuggestControl(oTextbox, oProvider) {
    this.cur = -1;
    this.layer = null;
    this.provider = oProvider;
    this.textbox = oTextbox;
    this.init(); // assegno la gestione del onkeyup del textbox alla funzione handleKeyUp
}

// creo il metodo selectRange della classe AutoSuggestControl
// questa funzione seleziona la stringa del textbox a partire da iStart per iLength caratteri
AutoSuggestControl.prototype.selectRange = function (iStart, iLength) {
    if (this.textbox.createTextRange) { // explorer
        var oRange = this.textbox.createTextRange();
        oRange.moveStart("character", iStart);
        oRange.moveEnd("character", iLength - this.textbox.value.length);
        oRange.select();
    } else if (this.textbox.setSelectionRange) { // mozilla
        this.textbox.setSelectionRange(iStart, iLength);
    }

    this.textbox.focus();
};

// funzione che seleziona scrive il Suggerimento sSuggestion nel textField e seleziona la parte rimanente da scrivere
// accetta come parametro la stringa suggerita sSuggestion e fa uso della funzione selectRange appena vista
AutoSuggestControl.prototype.typeAhead = function (sSuggestion) {
    if (this.textbox.createTextRange || this.textbox.setSelectionRange) {
        var iLen = this.textbox.value.length;
        this.textbox.value = sSuggestion;
        this.selectRange(iLen, sSuggestion.length);
    }
};

//funzione che controlla che i suggerimenti aSuggestions (ci possono essere + diuna parola che comincia per xxx) ci siano e seleziona la prima
// il secondo parametro serve per il dropDown menu, ed è un booleano che indica se fare o no il typeAhead, e se è false, nasconde la tendina
AutoSuggestControl.prototype.autosuggest = function (aSuggestions,  bTypeAhead) {
	
    if (aSuggestions.length > 0) {
	    if (bTypeAhead) {
	    
		    this.typeAhead(aSuggestions[0]);
		}
		this.showSuggestions(aSuggestions);
	    } else {
		this.hideSuggestions();
    }
};

// questa funzione controlla quale tasto è stato premuto e se è il caso di procedere con l'autosuggest
AutoSuggestControl.prototype.handleKeyUp = function (oEvent) {
    var iKeyCode = oEvent.keyCode;
    
    if (iKeyCode == 8 || iKeyCode == 46) {
        this.provider.requestSuggestions(this, false);

    } else if (iKeyCode < 32 || (iKeyCode >= 33 && iKeyCode <= 46) || (iKeyCode >= 112 && iKeyCode <= 123)) {
        //ignore
    } else {
        //this.provider.requestSuggestions(this);
	this.provider.requestSuggestions(this, true);
    }
};

// funzione per far gestire alla funzione handleKeyUp l'evento keyUp del controllo textbox della classe AutoSuggestControl
AutoSuggestControl.prototype.init = function () {
    var oThis = this;
    this.textbox.onkeyup = function (oEvent) { // quando si verifica un evento onkeyup, esegui questa funzione passandogli l'oggetto oEvent che è una cosa propria del DOM
        if (!oEvent) { // può essere che con Explorer non ci sia l'oggett oEvent, al suo posto viene utilizzato l'oggetto event della classe window
            oEvent = window.event;
        }
	
        oThis.handleKeyUp(oEvent); // assegno a handleKeyUp la gestione dell'evento onkeyUp
    };
    
    
    // per gestire le freccie e l'enter per il menu a tendina
    this.textbox.onkeydown = function (oEvent) {

        if (!oEvent) {
            oEvent = window.event;
        }

        oThis.handleKeyDown(oEvent);
    };
    
    // per gestire la perdita del focus, dovrò nascondere la tendina
     this.textbox.onblur = function () {
        oThis.hideSuggestions();
    };

    this.createDropDown();
};
