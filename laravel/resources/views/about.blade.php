<x-geomir-layout>
    <style>
        .image-container {
            position: relative;
            width: auto;
            height: auto;
            overflow: hidden;
            cursor: pointer;
        }

        .image-container img {
            width: auto;
            height: auto;
            object-fit: cover;
            transition: filter 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .image-container img:first-child {
            filter: grayscale(100%) contrast(150%);
        }

        .image-container:hover img:first-child {
            transform: rotateY(180deg);
        }

        .image-container img:last-child {
            position: absolute;
            top: 0;
            left: 0;
            width: auto;
            height: auto;
            object-fit: cover;
            transform: rotateY(180deg);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .image-container:hover img:last-child {
            opacity: 1;
            transform: rotateY(0deg);
        }
    </style>

    <x-slot:header class="bg-gray-900 text-white py-4">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold text-white">About Us</h1>
        </div>
    </x-slot:header>
    <x-slot:nav>
    <div class="izquierda  bg-yellow dark:bg-amber-300 flex flex-row justify-between w-full rounded-lg">
                <a class="border-2 border-black  p-2 rounded-lg mr-4 ml-4 mt-2 mb-2 mr-3" href="{{ url('home') }}"><img class="home w-12" src="{{ asset("img/home.png") }}"></a>
    </x-slot:nav>

    <main class="container mx-auto py-8">
        <div class="flex flex-col md:flex-row justify-center gap-8">
            <div class="max-w-xs mx-auto">
                <div class="border-2 border-black p-4 mb-4 transition duration-300 ease-in-out transform hover:scale-105">
                    <div class="image-container">
                        <img id="image1" src="{{ asset("img/kaydy-serio.jpeg") }}" alt="MesoMenys" class="w-full h-auto rounded-md mb-4">
                        <img id="image2" src="{{ asset("img/kaydy-about-us.jpg") }}" alt="MesoMenys" class="w-full h-auto rounded-lg mb-4 opacity-0 absolute top-0 left-0 transition duration-500 ease-in-out">
                    </div>
                    <div class="text-center">
                        <h2 class="text-lg font-semibold text-black">MesoMenys</h2>
                        <p class="text-gray-600">CEO (Es el zampa weikis de la empresa)</p>
                    </div>
                </div>
            </div>

            <div class="max-w-xs mx-auto">
                <div class="border-2 border-black p-4 mb-4">
                    <div class="image-container">
                        <img id="image3" src="{{ asset("img/yung-beef-serio.jpg") }}" alt="Empleado 2" class="w-full h-auto rounded-md mb-4">
                        <img id="image4" src="{{ asset("img/yung-beef-about-us.webp") }}" alt="Empleado 2" class="w-full h-auto rounded-lg mb-4 opacity-0 absolute top-0 left-0 transition duration-500 ease-in-out">
                    </div>
                    <div class="text-center">
                        <h2 class="text-lg font-semibold text-black">Poriro</h2>
                        <p class="text-gray-600">CEO (Es Barrenderoy zampa donetes a mansalva)</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const imageContainer1 = document.querySelector('.max-w-xs:first-child .image-container');
        const imageContainer2 = document.querySelector('.max-w-xs:last-child .image-container');

        imageContainer1.addEventListener('mouseover', () => {
            const image1 = document.getElementById('image1');
            const image2 = document.getElementById('image2');

            image1.classList.toggle('opacity-0');
            image2.classList.toggle('opacity-0');
        });

        imageContainer2.addEventListener('mouseover', () => {
            const image3 = document.getElementById('image3');
            const image4 = document.getElementById('image4');

            image3.classList.toggle('opacity-0');
            image4.classList.toggle('opacity-0');
        });
    </script>

    <x-slot:footer class="bg-gray-900 text-white py-4 text-center">
        <p>La Empresa de Pechiguitas Boys</p>
    </x-slot:footer>


</x-geomir-layout>
