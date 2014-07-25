<?
##interface de admin
?>
<script type="text/javascript">
function $i(id) { return document.getElementById(id); }
function $r(parent,child) { (document.getElementById(parent)).removeChild(document.getElementById(child)); }
function $t(name) { return document.getElementsByTagName(name); }
function $c(code) { return String.fromCharCode(code); }
function $h(value) { return ('0'+Math.max(0,Math.min(255,Math.round(value))).toString(16)).slice(-2); }
function _i(id,value) { $t('div')[id].innerHTML+=value; }
function _h(value) { return !hires?value:Math.round(value/2); }


function get_screen_size()
	{
	var w=document.documentElement.clientWidth;
	var h=document.documentElement.clientHeight;
	return Array(w,h);
	}

var url=document.location.href;

var flag=true;
var test=true;
var n=80;
var w=0;
var h=0;
var x=0;
var y=0;
var z=0;
var star_color_ratio=100;
var star_x_save,star_y_save;
var star_ratio=110;
var star_speed=4;
var star_speed_save=0;
var star=new Array(n);
var color;
var opacity=0.5;

var cursor_x=0;
var cursor_y=0;
var mouse_x=0;
var mouse_y=0;

var canvas_x=0;
var canvas_y=0;
var canvas_w=0;
var canvas_h=0;
var context_stars;
var context_fore;

var key;
var ctrl;

var timeout;
var fps=0;
var album_art_1 = new Image();
var album_art_2 = new Image();
var overlay_art = new Image();

var sourceX = 0;
var sourceY = 0;
var sourceWidth = 0;
var sourceHeight = 0;
var destWidth = 0;
var destHeight = 0;
var destX = 0;
var destY = 0;
var scale = 0;
var warp = 0;
var warp_percent = 0;

var warp_up = 0;
var warp_down = 0;
var warp_up_time = 1.5;
var warp_down_time = 3;
var opacity_min = .1;
var opacity_max = .5;
var speed_min = -1;
var speed_max = 10; 

var fadestars = 0;
var fadeincrement = .001;

var track = 0;
var overlay_fade = 0;
var overlay_img = "like.jpg";
var fade_action = "none";
var fade_count = 0;

var overlay_time = 0;
var current_track = 0;
var sc_fade = 1;
	
var shadow_center_x = 300
var shadow_center_y = 300;
var shadow_radius = 85;

var soundcloud_fade = 1;
var images = {};



      function loadImages(sources, callback) {

        var loadedImages = 0;
        var numImages = 0;
        // get num of sources
        for(var src in sources) {
          numImages++;
        }
        for(var src in sources) {
          images[src] = new Image();
          images[src].onload = function() {
            if(++loadedImages >= numImages) {
              callback(images);
            }
          };
          images[src].src = sources[src];
        }
      }

      var sources = {
        piece1: 'img/Metropolis_Remixed_(1500x1500)_1.png',
        piece2: 'img/Metropolis_Remixed_(1500x1500)_2.png'
      };

      loadImages(sources, function(images) {
			init();
      });








function init()
	{
	var a=0;
	for(var i=0;i<n;i++)
		{
		star[i]=new Array(5);
		star[i][0]=Math.random()*w*2-x*2;
		star[i][1]=Math.random()*h*2-y*2;
		star[i][2]=Math.round(Math.random()*z);
		star[i][3]=0;
		star[i][4]=0;
		star[i][5]=Math.round(Math.random()*100);
		}
	var starfield=$i('starfield');
	starfield.style.position='absolute';
	starfield.width=w;
	starfield.height=h;

	context_stars=starfield.getContext('2d');
	context_stars.fillStyle='rgb(13, 67, 147)';
	context_stars.strokeStyle='rgb(13, 67, 147)';

	var foreground = $i('foreground');
	foreground.style.position='absolute';
	foreground.width=w;
	foreground.height=h;

	context_fore=foreground.getContext('2d');
	context_fore.fillStyle='rgba(13, 67, 147, 0.8)';
	context_fore.clearRect(0,0,w,h);

	var overlay = $i('overlay');
	overlay.style.position='absolute';
	overlay.width=w;
	overlay.height=h;

	context_overlay=overlay.getContext('2d');
	context_overlay.fillStyle='rgba(13, 67, 147, 0.8)';
	context_overlay.clearRect(0,0,w,h);

	var input = $i('input_coordinates');
	input.style.position = 'absolute';
	input.style.top = h*.9 + "px";
	input.style.left = w/2 - 70 + "px";

	var sc_div = $i('soundcloud');
	sc_div.style.position = 'absolute';
	sc_div.style.top = h*.75 + "px";
	sc_div.style.left = w/2 - 250 + "px";

	var shadow = $i('shadow');
	var shadow_gif = $i('shadowgif');

	draw_overlays();

	}

function anim()
	{
	mouse_x=cursor_x-x;
	mouse_y=cursor_y-y;



	if (warp > 0) {
		if (warp == 1) {
			warp_up += .02;
			warp_percent = warp_up / warp_up_time;
			opacity = opacity_max - ((opacity_max - opacity_min) * warp_percent);
			star_speed = speed_min + ((speed_max - speed_min) * warp_percent);

			if (overlay_fade > 0) {
					overlay_fade = 1 - warp_percent;
					draw_overlays();			
			}


			if (warp_up >= warp_up_time) {
				overlay_fade = 0;
				warp_up = 0;
				warp = 2;
				get_coordinates();
			}

		}
		if (warp == 2){
			warp_down += .02;
			warp_percent = (1 - warp_down / warp_down_time);
			opacity = opacity_max - ((opacity_max - opacity_min) * warp_percent);
			star_speed = speed_min + ((speed_max - speed_min) * warp_percent);


			if (warp_down >= warp_down_time) {
				warp_down = 0;
				warp = 0;
				fade_action = "in";
			}
		}
	}

	else {
		opacity = opacity_max;
		star_speed = speed_min;
	}


	context_stars.fillRect(0,0,w,h);
	context_stars.fillStyle='rgba(0,0,0,'+opacity+')';

	
	for(var i=0;i<n;i++)
		{
		test=true;
		star_x_save=star[i][3];
		star_y_save=star[i][4];
		star[i][0]+=mouse_x>>4; if(star[i][0]>x<<1) { star[i][0]-=w<<1; test=false; } if(star[i][0]<-x<<1) { star[i][0]+=w<<1; test=false; }
		star[i][1]+=mouse_y>>6; if(star[i][1]>y<<1) { star[i][1]-=h<<1; test=false; } if(star[i][1]<-y<<1) { star[i][1]+=h<<1; test=false; }
		star[i][2]-=star_speed; if(star[i][2]>z) { star[i][2]-=z; test=false; } if(star[i][2]<0) { star[i][2]+=z; test=false; }
		star[i][3]=x+(star[i][0]/star[i][2])*star_ratio;
		star[i][4]=y+(star[i][1]/star[i][2])*star_ratio;
		if(star_x_save>0&&star_x_save<w&&star_y_save>0&&star_y_save<h&&test)
			{
			if (star[i][5] >= 90) { context_stars.strokeStyle='rgba(255, 255, 255, 1)'; }
			if (star[i][5] <90) { context_stars.strokeStyle='rgba(194, 232, 34, 0.9)'; }


			context_stars.lineWidth=(1-star_color_ratio*star[i][2])*2;
			context_stars.beginPath();
			context_stars.moveTo(star_x_save,star_y_save);
			context_stars.lineTo(star[i][3],star[i][4]);
			context_stars.stroke();
			context_stars.closePath();
			}
		}

		fade_overlays();
	}




function draw_overlays()
	{

	album_art_1 = images.piece1;
	album_art_2 = images.piece2;
	overlay_art.src = overlay_img;


	shadowgif.style.opacity = .3 * overlay_fade;
	context_overlay.globalAlpha= overlay_fade;


	if (sc_fade != 2) {
		var mydiv = document.getElementById("soundcloud");
		mydiv.style.opacity = .7 * overlay_fade;
	}


	if (w >= h) {
		scale = w/album_art_1.width;
			
		sourceX = 0;
		sourceY = (1 - (h/w)) * album_art_1.height / 2; 
		sourceWidth = album_art_1.width;
		sourceHeight = (h/w) * album_art_1.height;
		destWidth = w;
		destHeight = h;
		destX = 0;
		destY = 0;


		shadow_center_x = (562 - sourceX) * scale;
		shadow_center_x -= (shadow_radius * scale);
		shadow_center_y = (608 - sourceY) * scale;
		shadow_center_y -= (shadow_radius * scale);

		shadow.style.top = shadow_center_y + "px";
		shadow.style.left = shadow_center_x + "px";

		shadowgif.style.height = (shadow_radius * 2 * scale)+ "px";
		shadowgif.style.width = (shadow_radius * 2 * scale) + "px";


		context_fore.clearRect(0,0,w,h);
		context_fore.drawImage(album_art_1,sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);
		context_fore.drawImage(album_art_2,sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);

		context_overlay.clearRect(0,0,w,h);
		context_overlay.drawImage(overlay_art,sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);
	}
	
	if (w < h) {
		scale = h/album_art_1.height;
			
		sourceX = (1 - (w/h)) * album_art_1.width / 2;
		sourceY = 0; 
		sourceWidth = (w/h) * album_art_1.width;
		sourceHeight = album_art_1.height;
		destWidth = w;
		destHeight = h;
		destX = 0;
		destY = 0;

		shadow_center_x = (562 - sourceX) * scale;
		shadow_center_x -= (shadow_radius * scale);
		shadow_center_y = (608 - sourceY) * scale;
		shadow_center_y -= (shadow_radius * scale);

		shadow.style.top = shadow_center_y + "px";
		shadow.style.left = shadow_center_x + "px";

		shadowgif.style.height = (shadow_radius * 2 * scale)+ "px";
		shadowgif.style.width = (shadow_radius * 2 * scale) + "px";

		context_fore.clearRect(0,0,w,h);
		context_fore.drawImage(album_art_1,sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);
		context_fore.drawImage(album_art_2,sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);

		context_overlay.clearRect(0,0,w,h);
		context_overlay.drawImage(overlay_art,sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);
	}
	}




function move(evt)
	{
	evt=evt||event;
	cursor_x=evt.pageX-canvas_x;
	cursor_y=evt.pageY-canvas_y;
	}


function start()
	{
	setInterval(anim, 20);
	resize();
	draw_overlays();
	}


function resize()
	{

	w=parseInt((url.indexOf('w=')!=-1)?url.substring(url.indexOf('w=')+2,((url.substring(url.indexOf('w=')+2,url.length)).indexOf('&')!=-1)?url.indexOf('w=')+2+(url.substring(url.indexOf('w=')+2,url.length)).indexOf('&'):url.length):get_screen_size()[0]);
	h=parseInt((url.indexOf('h=')!=-1)?url.substring(url.indexOf('h=')+2,((url.substring(url.indexOf('h=')+2,url.length)).indexOf('&')!=-1)?url.indexOf('h=')+2+(url.substring(url.indexOf('h=')+2,url.length)).indexOf('&'):url.length):get_screen_size()[1]);

	if (w<640) {
		w=640;
	}	
	if (h<480) {
		h=480;
	}	


	x=Math.round(w/2);
	y=Math.round(h/2);
	z=(w+h)/2;
	star_color_ratio=1/z;
	cursor_x=x;
	cursor_y=y;
	init();
	}

function goClick()
	{
		if (warp == 0) {warp = 1;}
		var elem = document.getElementById("input_field");
		coordinates = elem.value;
	}

function get_coordinates(){
	
	var coords = $('#input_field').val();

	$.ajax({
	dataType: "json",
	type: "POST",
	url: "coordinates.php",
	data: {fcoords:coords}
	}).done(function(returned) {

	if (returned.track == current_track) {
		sc_fade = 0;
	}
	else if (returned.track == 0) {
		sc_fade = 0;
	}
	else {
		sc_fade = 1;
	}


		overlay_img = returned.img;
		track = returned.track;	
		current_track = returned.track;


	if (sc_fade == 1) {
		var mydiv = document.getElementById("soundcloud");
		mydiv.innerHTML = "";

		if (returned.url != "none") {

			var aTag = document.createElement('a');
			aTag.setAttribute('href',returned.url);
			aTag.setAttribute('class',"sc-player");
			aTag.innerHTML = "SONG";
			mydiv.appendChild(aTag);

			$('a.sc-player').scPlayer();
		}
	}


	shadow_radius = returned.radius;
	draw_overlays();

	});
}


document.onmousemove=move;

</script>
