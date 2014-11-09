var hl;
(function($){
    
    $(document).ready(function(){
        hl.lightbox.init();
        hl.tip.init();
        hl.carrousel.init();
        hl.tabs.init();
        hl.metamapa.init();
        // load google maps 
        
        
        
        // hl.cidadeUfAutocomplete.init();
        
        // TEMPLATE WIDGETS - AJAX
        $('.template-widget-form').live('submit',function(){
            var div_id = $(this).data("div_id");
            $.post(vars.ajaxurl,$(this).serialize(),function (response){
                if(response){
                    $('.hl-lightbox-close').click();
                    $('#'+div_id).html(response);
                }
            });
            return false;
        });

        // TABS - Skeleton WP (http://demos.simplethemes.com/skeleton/)
        var tabs = $('ul.tabs');
        tabs.each(function(i) {
            //Get all tabs
            var tab = $(this).find('> li > a');
            $("ul.tabs li:first").addClass("active").fadeIn('fast'); //Activate first tab
            $("ul.tabs li:first a").addClass("active").fadeIn('fast'); //Activate first tab
            $("ul.tabs-content li:first").addClass("active").fadeIn('fast'); //Activate first tab
            
            tab.click(function(e) {
                
                //Get Location of tab's content
                var contentLocation = $(this).attr('href') + "Tab";
                
                //Let go if not a hashed one
                if(contentLocation.charAt(0)=="#") {
                
                    e.preventDefault();
                
                    //Make Tab Active
                    tab.removeClass('active');
                    $(this).addClass('active');
                    
                    //Show Tab Content & add active class
                    $(contentLocation).show().addClass('active').siblings().hide().removeClass('active');
                    
                } 
            });
        });

        // TOGGLE - Skeleton WP (http://demos.simplethemes.com/skeleton/)
        $(function(){ // run after page loads
            $(".toggle_container").hide(); 
            //Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
            $("p.trigger").click(function(){
                $(this).toggleClass("active").next().slideToggle("normal");
                return false; //Prevent the browser jump to the link anchor
            });
        });
    });
    
    
    hl = {
        
        validate: {
            date: function (d,m,y){
                var dt = new Date();
                
                d = parseInt(d,10);
                m = parseInt(m,10)-1;
                y = parseInt(y,10);
                
                dt.setYear(y);
                dt.setMonth(m);
                dt.setDate(d);
                
                if(dt.getDate()!=d){
                    return false;
                }
                else if(dt.getMonth()!=m){
                    //this is for the purpose JavaScript starts the month from 0
                    return false;
                }
                else if(dt.getFullYear()!=y){
                    return false;
                }
        
                return true;
            },
            
            email: function(email){
                var reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                return reg.test(email);
            }
        },
                
        /**
         * Seleciona o texto do elemento
         */
        selectText: function(element) {
            var doc = document;
            var text;
            
            if(typeof element == 'string')
                text = doc.getElementById(element);    
            else
                text = element;
            
            if (doc.body.createTextRange) { // ms
                var range = doc.body.createTextRange();
                range.moveToElementText(text);
                range.select();
            } else if (window.getSelection) { // moz, opera, webkit
                var selection = window.getSelection();            
                var range = doc.createRange();
                range.selectNodeContents(text);
                selection.removeAllRanges();
                selection.addRange(range);
            }
        },
                
        metamapa: {
            init: function(){
                if($('.hl-metamapa').length){
                    var script = document.createElement("script");
                    script.type = "text/javascript";
                    script.src = "http://maps.google.com/maps/api/js?sensor=true&callback=hl.metamapa.openMaps";
                    document.body.appendChild(script);
                }
            },
            openMaps: function(){
               $('.hl-metamapa').each(function(){
                   if($(this).data('map'))
                       return true;
                   
                   var lat = parseFloat($(this).data('lat')),
                       lon = parseFloat($(this).data('lon'));
                   
                   var options = {
                       zoom: $(this).data('zoom'), 
                       mapTypeId: $(this).data('maptype'),
                       center: new google.maps.LatLng(lat,lon)
                   };
                   var map = new google.maps.Map(this, options);
                   
                   $(this).data('map', map);
                   
                   if($(this).data('show-pin')){
                       $(this).data('pin', new google.maps.Marker({
                           map: map,
                           position: new google.maps.LatLng(lat,lon)
                       }));
                   }
               });
            }
        },
        
        /**
         * modo de usar: <tag class=".hltip" title="Title: Content text" >
         */
        tip:{
            init: function(){
                $(".hltip").live('mouseenter, mousemove',function(e){
                    var tip = $(this).data('tip');
                    var _left = e.clientX + $(document).scrollLeft() - 45;
                    var _top = $(this).offset().top ;
                    var _height = $(this).height();
                
                    if(!tip){
                        var content = $(this).attr('title');
                    
                        if(content.indexOf(':') > 0){
                            content = '<div class="hltip-title">'+(content.substr(0, content.indexOf(':')))+'</div>'+(content.substr(content.indexOf(':')+1));
                        }
                        tip = $('<div class="hltip-box"><div class="hltip-arrow-top"></div><div class="hltip-text">'+content+'</div><div class="hltip-arrow-bottom"></div></div><').hide();
                        tip.css({
                            position:'absolute', 
                            zIndex: 9999
                        });
                        $(document.body).append(tip);
                        tip.css('width', tip.width());
                        $(this).data('tip',tip);
                        $(this).attr('title','');
                    }
                    if(_left+tip.width() - $(document).scrollLeft() > $(window).width() - 11)
                        tip.css('left', $(window).width() - 11 - tip.width() + $(document).scrollLeft());
                    else if(_left - $(document).scrollLeft() < 6)
                        tip.css('left',$(document).scrollLeft()+6);
                    else
                        tip.css('left', _left);

                    var diff = e.clientX + $(document).scrollLeft() - parseInt(tip.css('left'));
                
                    if(diff < 1)
                        diff = 1;
                    else if (diff > parseInt(tip.outerWidth()) -11)
                        diff = parseInt(tip.outerWidth()) -11;
                
                    if($(window).height() + $(document).scrollTop() - 11 < _top + _height + tip.height()){
                        tip.find('.hltip-arrow-top').hide();
                        tip.find('.hltip-arrow-bottom').show();
                        tip.css('top', _top - tip.height() - 6);

                        tip.find('.hltip-arrow-bottom').css('margin-left',diff);
                    }else{
                        tip.find('.hltip-arrow-top').show();
                        tip.find('.hltip-arrow-bottom').hide();
                        tip.find('.hltip-arrow-top').css('margin-left',diff);
                        tip.css('top', _top + _height + 6);
                    }

                    if(!tip.is(':visible')){
                        tip.fadeIn('fast');
                    }
                });
            
                $(".hltip").live('mouseleave',function(e){
                    $(this).data('tip').fadeOut('fast');
                
                });
            }
        
        },
    
        
        
        tabs: {
            init: function(selector){
                selector = selector || '.hl-tabs';
                
                $(selector).each(function(){
                    if($(this).data('hl-tabs-init'))
                        return true;
                    
                    var $this = $(this),
                        $nav = $this.find('.hl-tabs-nav'),
                        $contents = $this.find('.hl-tabs-contents');
                        
                    $nav.css('cursor', 'pointer');
                    
                    $nav.find('>').each(function(i){
                        var $el = $(this);
                        if(!$el.data('selector') || !$contents.find($el.data('selector')).length){
                            if($el.prop('tagName') === 'A' && $el.prop('href') !== '' && $el.prop('href') !== '#' && $contents.find($el.prop('href')).length === 1){
                                $el.data('selector', $el.prop('href'));
                            }else{
                                $el.data('selector', ':eq(' + i + ')');
                            }
                        }
                    }).click(function(){
                        if($(this).hasClass('active'))
                            return true;
                        $contents.find($nav.find('>.active').data('selector')).hide();
                        $contents.find($(this).data('selector')).show();
                        $nav.find('>.active').removeClass('active');
                        $(this).addClass('active');
                        
                        return false;
                    });
                    if($nav.find('>.active').length)
                        $nav.find('>.active').click();
                    else
                        $nav.find('>:first').click();
                });
            }
        },
        
        lightbox: {
            close_button_label: 'x',
            darkbox_css: {
                opacity: .8
            },
            lightbox_css: {
                opacity: 1
            },
            darkbox: null,
            lightbox: null,
		
            init: function (){
                // cria o darkbox ( div que deixa o fundo escuro )
                if($('.hl-darkbox').length == 0){
                    $(document.body).append("<div class='hl-darkbox'></div>");
                    this.darkbox = $('.hl-darkbox');
                    this.darkbox.click(function(){
                        hl.lightbox.close();
                    });
                }
			
                $('.hl-lightbox').each(function(){
                    $(this).data('dialog', $(this).find('.hl-lightbox-dialog'));
				
                });
			
                $('.hl-lightbox-dialog').each(function(){
                    $(this).hide();
                    $(document.body).append(this);
				
                    $(this).find('.hl-lightbox-close').click(function(){
                        hl.lightbox.close();
                        return false;
                    });
                });
			
                $('.hl-lightbox').click(function(){
                    var dialog = $(this).data('dialog');
                    hl.lightbox.open(dialog);
                    return false;
                });
			
            },
		
            open: function(div){
                this.lightbox = div;
			
                var _width = parseInt(div.css('width'));
                var _height = parseInt(div.css('height'));
			
                var _left = (parseInt($(window).width()/2 - _width/2))+'px';
                var _top = (parseInt($(window).height()/2 - _height/2) + $(window).scrollTop())+'px'; 
			
                this.darkbox.css({
                    opacity: 0, 
                    position:'absolute', 
                    top:'0px', 
                    left:'0px', 
                    zIndex: '9998', 
                    width: '100%', 
                    height: $(document).height()+'px'
                }).show().animate(this.darkbox_css);
                div.css({
                    opacity: 0, 
                    position:'absolute', 
                    left: _left, 
                    top: _top, 
                    zIndex: '9999'
                }).show().animate(this.lightbox_css,'fast');
                $(document.body).css('overflow', 'hidden');
            },
		
            close: function(){
                this.darkbox.hide();
                this.lightbox.hide();
                $(document.body).css('overflow', 'auto');
            }
        },
    
    
        /**
         * MODO DE USAR:
         * <section class='hl-carrousel' <!-- data-scroll-num="2"--> >
         *      <div class='hl-wrapper'>
         *          <article></article>
         *          <article></article>
         *          .
         *          .
         *          .
         *      </div>
         *      <nav>
         *          <element class='hl-nav-left' />  <!-- qualquer elemento com a classe hl-nav-left -->
         *          <element class='hl-nav-right' />  <!-- qualquer elemento com a classe hl-nav-right -->
         *      </nav>
         * </section>
         * 
         * nota: os elementos com as classes hl-nav-rig
         */
        carrousel: {
            init: function(){
                $('.hl-carrousel').each(function(){
                    var $this = $(this);
                    var $wrapper = $(this).find('>.hl-wrapper');
                    $wrapper.append('<div class="hl-wrapped"></div>');
                    var $wrapped = $wrapper.find('>.hl-wrapped');
                    
                    var $articles = $wrapper.find('>article');
                    
                    var $left = $(this).find('>nav>.hl-nav-left');
                    var $right = $(this).find('>nav>.hl-nav-right');
                    
                    var wrapped_width = 0;
                    var cindex = 0;
                    
                    var aleft = [];
                    
                    var inc = $this.data('scroll-num') ? $this.data('scroll-num') : 1;
                    
                    $wrapper.css({overflow: 'hidden', position: 'relative', width: '100%'});
                    $wrapped.css({position: 'absolute', left: 0});
                    
                    $articles.each(function(){
                        $wrapped.append(this);
                        /*
                         * como os articles tem posição absoluta é preciso definir a altura 
                         * wrapper igual à altura do maior dos articles
                         */
                        if($wrapper.innerHeight() < $(this).outerHeight(true))
                            $wrapper.css('height',$(this).outerHeight(true));
                           
                           
                        aleft.push(wrapped_width);
                        wrapped_width += $(this).outerWidth(true);
                        
                        $wrapped.css('width',wrapped_width);
                    });
                    
                    
                    // achando o ultimo indece de scroll
                    var last_index = $articles.length;
                    var hw = 0;
                    for(var i = $articles.length - 1; i >= 0; i--){
                        hw += $($articles[i]).outerWidth(true);
                        if(hw < $wrapper.innerWidth())
                            last_index = i;
                    }
                    
                    
                    $right.click(function(){
                        if(cindex + inc >= last_index && cindex + 1 < last_index)
                            cindex = last_index-1;
                        else
                            cindex += inc;
                        
                        if(cindex >= last_index)
                            cindex = 0;
                        
                        $wrapped.animate({left: -aleft[cindex]});
                        
                    });
                    
                     $left.click(function(){
                        if(cindex - inc < 0 && cindex - 1 >= 0)
                            cindex = 0
                        else
                            cindex -= inc;
                        
                        if(cindex < 0)
                            cindex = last_index-1;
                        
                        $wrapped.animate({left: -aleft[cindex]});
                        
                    });
                    
                    
                });
            }
        }
    };
})(jQuery);