// modal

function ouvrirModal(){
   document.querySelector(".modalPartenaire").classList.add("show");
}

function fermerModal(){
   document.querySelector(".modalPartenaire").classList.remove("show");
}

// observeur
const observer = new IntersectionObserver((entries) => {
   entries.forEach((entry)=>{
      console.log(entry)
      if  (entry.isIntersecting){
         entry.target.classList.add('show');
      }
   });
});

const hiddenElements= document.querySelectorAll('.hidden');
hiddenElements.forEach((el)=> observer.observe(el));