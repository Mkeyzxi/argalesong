document.addEventListener('DOMContentLoaded', function (){
	document.getElementById('menu-humburger').addEventListener('click', (e) => {
		e.preventDefault();
		e.currentTarget.classList.toggle('humburger');
		const aside = document.getElementById('aside');
		const asideTextChild = aside.querySelector('.sidebar-item .text');
		aside.classList.toggle('hidden');
		aside.style.width = '250px';
		for(let i = 0; i < asideTextChild.length; i++) {
			// asideTextChild[i].classList.toggle('hidden');
            asideTextChild[i].style.opacity = asideTextChild[i].classList.contains('hidden')? 0 : 1;
		}		
		// navbar ketika discroll	
	});

	const navbar = document.getElementById('navbar');
		let prevScrol = window.pageYOffset;
		window.addEventListener('scroll', () => {
			let currentScrol = window.pageYOffset;
			if (prevScrol > currentScrol) {
				navbar.style.top = "0";
			} else {
				navbar.style.top = "-75px";
			}
			prevScrol = currentScrol;
		});
})

