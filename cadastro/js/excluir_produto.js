function confirmarClique(id) {
    Swal.fire({
        title: 'Confirmar Exclusão',
        text: 'Tem certeza que deseja excluir esse Produto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, Excluir!',
        cancelButtonText: 'Cancelar',
        customClass: {
            popup: 'custom-swal-popup' // Adicione uma classe personalizada ao popup
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Se o usuário confirmar, redirecione para excluir_admin.php com o ID do administrador
            window.location.href = `excluir_produto.php?id=${id}`;
        }
    });
}
