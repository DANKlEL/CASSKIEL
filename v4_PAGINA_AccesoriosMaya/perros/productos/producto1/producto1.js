(function() {
    let scene1, camera1, renderer1, controls1, currentModel1;
    const loader1 = new THREE.FBXLoader();
    
    // Ruta verificada según tu captura
    const PATH_MODELO = '/AccesoriosMaya/perros/productos/producto1/source/producto1.fbx';

    function init() {
        const container = document.getElementById('container-3d-dog1');
        if (!container) return;

        scene1 = new THREE.Scene();
        // Cambiamos el fondo a un gris muy claro para ver si el objeto es blanco
        scene1.background = new THREE.Color(0xeeeeee);

        camera1 = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 1, 2000);
        camera1.position.set(100, 100, 100); 

        // Luz ambiental fuerte
        const ambientLight = new THREE.AmbientLight(0xffffff, 2.0); 
        scene1.add(ambientLight);

        // Luz direccional para dar sombras y profundidad
        const light = new THREE.DirectionalLight(0xffffff, 1.2);
        light.position.set(100, 200, 500);
        scene1.add(light);

        renderer1 = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer1.setSize(container.clientWidth, container.clientHeight);
        renderer1.setPixelRatio(window.devicePixelRatio);
        renderer1.outputEncoding = THREE.sRGBEncoding;
        container.appendChild(renderer1.domElement);

        controls1 = new THREE.OrbitControls(camera1, renderer1.domElement);
        controls1.enableDamping = true;

        cargarModelo(PATH_MODELO);
        animate();
    }

    function cargarModelo(path) {
        loader1.load(path, function (object) {
            currentModel1 = object;
            
            // ESCALA: Si no se ve, prueba cambiar este valor (ej. 1, 10, o 100)
            // Muchos modelos de C4D vienen en cm y Three.js usa unidades genéricas
            currentModel1.scale.set(25, 25, 25); 

            // Centrar automáticamente el modelo
            const box = new THREE.Box3().setFromObject(currentModel1);
            const center = box.getCenter(new THREE.Vector3());
            const size = box.getSize(new THREE.Vector3());
            
            currentModel1.position.sub(center);
            
            // Ajustar cámara al tamaño del objeto
            const maxDim = Math.max(size.x, size.y, size.z);
            camera1.position.z = maxDim * 2.5;

            scene1.add(currentModel1);
            console.log("Hueso cargado. Tamaño detectado:", size);
        }, 
        (xhr) => { console.log((xhr.loaded / xhr.total * 100) + '% cargado'); },
        (error) => { console.error("Error cargando FBX:", error); });
    }

    function animate() {
        requestAnimationFrame(animate);
        if(controls1) controls1.update();
        renderer1.render(scene1, camera1);
    }

    init();
})();