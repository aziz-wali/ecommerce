

let subMenu = document.querySelector('.sub-menu');
let item =document.querySelector('.fa-angle-down');
item.onclick =function(){
	if(subMenu.style.display=='block'){
		subMenu.style.display='none'
	}else{
		subMenu.style.display='block'
	}
}
//remove serarch result div 
let searchresult = document.querySelector('.search-result');
document.body.onclick =function(){
	searchresult.remove();
}
// search form and onclick ,blur effects
let placeholder ='';
let search = document.querySelector('.search-form input');
search.onfocus= function(){
	 placeholder = search.getAttribute('placeholder')
	this.setAttribute('placeholder','')
}
search.onblur= function (){
	this.setAttribute('placeholder',placeholder)
}
//___________user menu controll____________
let user = document.querySelector('.user');
let dropdown = document.querySelector('.user-dropdown');
user.onclick= function(){
	if(dropdown.style.display=='none'){
		dropdown.style.display='block'
	}else{
		dropdown.style.display='none'
	}
}
window.onclick=function(){
	dropdown.style.display='none'
}
//__________________color___________
let colors = document.querySelectorAll('.colors ul li');
let arr = [];
for(let i=0; i<colors.length; i++){
	arr.push(colors[i].getAttribute('data-color'));
	colors[i].addEventListener('click',function(){
		document.body.classList.remove(...arr)
		document.body.classList.add(this.getAttribute('data-color'))
	});
}

//___________slider imag_________
let images = document.querySelectorAll('.gallery img');
let pagination = document.querySelectorAll('.pagination li');
let counter =1;
for(let i =0; i<images.length; i++){
	pagination[i].addEventListener('click',function (){
   
		images.forEach(function(img){
			clearInterval(loop)
			img.classList.remove('active')
		})
		pagination.forEach(function(li){
			li.classList.remove('active')
		})
		images[pagination[i].getAttribute('data-number')-1].classList.add('active')
		pagination[pagination[i].getAttribute('data-number')-1].classList.add('active')
	
	})
}
function click(){
	counter++;
	if(counter> images.length){
		counter=1
	}
	images.forEach(function(img){
		img.classList.remove('active')
	})
	pagination.forEach(function(li){
		li.classList.remove('active')
	})
	images[counter-1].classList.add('active')
	pagination[counter-1].classList.add('active')



}
let loop =setInterval(click,2000);

let popup =document.querySelector('.popup ');

window.onload=function(){
	popup.style.display='block';


}
setTimeout(function(){
		popup.style.display='none';
},500);

