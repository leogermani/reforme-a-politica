hl.cidadeUfAutocomplete = {
            init: function(){
                $('.cidade-uf-autocomplete').each(function(){
                    $el = $(this);
                    $el.autocomplete({
                        source: [],
                        search: function(){
                            var uid = $el.data('uid');
                            var data = $el.data('autocomplete-data');
                            var cidade = data ? data[$el.val()] : null;
                            
                            if(cidade){
                                $('#'+uid+'-uf').val(cidade['uf_'+$el.data('uf-property')]);
                                $('#'+uid+'-cidade').val(cidade['cidade_'+$el.data('cidade-property')]);
                            }else{
                                $('#'+uid+'-uf').val('');
                                $('#'+uid+'-cidade').val('');
                            }
                            
                            if(!$el.data('autocomplete-loading')){
                                $el.data('autocomplete-loading',true);
                                $.getJSON(vars.ajaxurl, {action:'get_ibge_cidade_uf', value: $el.val()}, function(result){
                                    $el.data('autocomplete-data', result);
                                    $el.autocomplete('option','source',result.keys);
                                    
                                    $el.autocomplete('search', $el.val());
                                        
                                    $el.data('autocomplete-loading',false);
                                    $el.data('autocomplete-exec',true);
                                });
                                return false;
                            }
                        },
                        select: function(event, ui){
                            var $el = $(this);
                            var data = $el.data('autocomplete-data');
                            var cidade = data[ui.item.value];
                            var uid = $el.data('uid');
                            $('#'+uid+'-uf').val(cidade['uf_'+$el.data('uf-property')]);
                            $('#'+uid+'-cidade').val(cidade['cidade_'+$el.data('cidade-property')]);
                        }
                    });
                })
            }
        };