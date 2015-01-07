(function($, scope, undefined) {
    scope.ssItemParservimeo = scope.ssItemParser.extend({
        parse: function(name, data){
            var o = this._super(name, data);
            if(name === 'vimeourl'){
                var regExp = /http:\/\/(?:www\.|player\.)?(vimeo|youtube)\.com\/(?:embed\/|video\/)?(.*?)(?:\z|$|\?)/;
                var match = data.match(regExp);
                if (match&&match[2]){
                    o.code = match[2];
                }else{
                    o.code = data;
                }
                delete o.size;
            }
            return o;
        }
    });
})(njQuery, window);
