// const truc = document.querySelector('.supp')

// truc.addEventListener("click", loadAlertDelete)

// function loadAlertDelete(e) 
// {

//   e.preventDefault();

//     const confirmation_supprimer = document.querySelectorAll(".supp");
                
//     confirmation_supprimer.forEach(element => {
//         element.addEventListener("click", Swal.fire)
//     });



    
//     Swal.fire({
//         title: 'Supprimer l\'ingrédient ?',
//         text: "L'ingrédient ne pourra plus être récupéré...",
//         icon: 'error',
//         showCancelButton: true,
//         confirmButtonColor: 'rgb(219, 44, 44)',
//         cancelButtonColor: 'rgb(17, 122, 141)',
//         confirmButtonText: 'Supprimer'
//       }).then((result) => {
//         if (result.isConfirmed) 
//         {
//           Swal.fire(
//             'Suppression',
//             'Votre ingrédient a été supprimé !',
//             'success'
//           )
//         }
//       })

// }



const confirmation_supprimer = document.querySelectorAll(".supp");
                
confirmation_supprimer.forEach(element => {
    element.addEventListener("click", confirmDelete)
});

function confirmDelete(e)
{
    if(Swal.fire({
      title: 'Supprimer l\'ingrédient ?',
      text: "L'ingrédient ne pourra plus être récupéré...",
      icon: 'error',
      showCancelButton: true,
      confirmButtonColor: 'rgb(219, 44, 44)',
      cancelButtonColor: 'rgb(17, 122, 141)',
      confirmButtonText: 'Supprimer'
    }) == 'false') 
    {
        e.preventDefault();
    }
}





// Swal.fire({
//           title: 'Supprimer l\'ingrédient ?',
//           text: "L'ingrédient ne pourra plus être récupéré...",
//           icon: 'error',
//           showCancelButton: true,
//           confirmButtonColor: 'rgb(219, 44, 44)',
//           cancelButtonColor: 'rgb(17, 122, 141)',
//           confirmButtonText: 'Supprimer'
//         }).then((result) => {
//           if (result.isConfirmed) 
//           {
//             Swal.fire(
//               'Suppression',
//               'Votre ingrédient a été supprimé !',
//               'success'
//             )
//           }
//         })