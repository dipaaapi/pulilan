const Dropdown = document.querySelector(".dropdown");
const Label = document.querySelector("#label");

/*const GetSum = (x, y) => x + y;

console.log(GetSum(300, 500));*/

const LabelAlert = (Label) => Label > 0;

console.log("you have a message!");

Dropdown.addEventListener("click", function(e) {
	e.preventDefault();
	Dropdown.style.background = "red";
	Dropdown.style.color = "white";
	Dropdown.style.transition = ".5s";
}),

Dropdown.addEventListener("click", function(e) {
	e.preventDefault();
	console.log("running");

	if(Label => 1) {
		Label.style.padding = "2rem";
		Label.style.transition = ".5s";
	}else {
		console.log("no message");
	}
})