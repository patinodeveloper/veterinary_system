document.addEventListener('DOMContentLoaded', function () {
    const speciesSelect = document.getElementById('species_id');
    const breedSelect = document.getElementById('breed_id');

    if (speciesSelect && breedSelect) {
        // Función para cargar las razas segun la especie seleccionada
        function loadBreeds(speciesId) {

            // Se crea el elemento option
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'No especificada';

            // Limpia el select de razas
            breedSelect.innerHTML = '';
            breedSelect.appendChild(option);

            if (!speciesId) return;

            // Peticion para obtener las razas por el ID de una species
            fetch(`/api/species/${speciesId}/breeds`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json()) // Convierte la response en JSON
                .then(breeds => { // Recorre cada raza y crea un option por raza para el select
                    breeds.forEach(breed => {
                        const option = document.createElement('option');
                        option.value = breed.id;
                        option.textContent = breed.name;
                        breedSelect.appendChild(option);
                    });

                    // Si hay un valor preseleccionado lo mantiene (en caso de edicion)
                    const preselectedBreed = breedSelect.getAttribute('data-preselected');
                    if (preselectedBreed) {
                        breedSelect.value = preselectedBreed;
                    }
                })
                .catch(error => console.error('Error cargando razas:', error));
        }

        // Carga las razas cuando cambia la especie
        speciesSelect.addEventListener('change', function () {
            loadBreeds(this.value);
        });

        // Carga las razas inicialmente si hay una especie preseleccionada (para edit)
        if (speciesSelect.value) {
            loadBreeds(speciesSelect.value);
        }
    }
});