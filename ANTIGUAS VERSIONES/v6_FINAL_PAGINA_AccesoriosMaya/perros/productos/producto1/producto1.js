(function() {
    let scene1, camera1, renderer1, controls1, currentModel1;
    const loader1 = new THREE.FBXLoader();
    
    // RUTA ACTUALIZADA: Se cambió el nombre del archivo a produc1.fbx
    const PATH_MODELO = '/AccesoriosMaya/perros/productos/producto1/source/produc1.fbx';

    function init() {
        const container = document.getElementById('container-3d-dog1');
        if (!container) return;

        // Escena y Cámara
        scene1 = new THREE.Scene();
        scene1.background = new THREE.Color('#95b7bc'); // Color aplicado correctamente

        camera1 = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 1, 4000);
        camera1.position.set(150, 100, 150); 

        // Iluminación
        const ambientLight = new THREE.AmbientLight(0xffffff, 1.2); 
        scene1.add(ambientLight);

        const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(100, 200, 100);
        scene1.add(directionalLight);

        // Renderizador
        renderer1 = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer1.setSize(container.clientWidth, container.clientHeight);
        renderer1.setPixelRatio(window.devicePixelRatio);
        renderer1.outputColorSpace = THREE.SRGBColorSpace;
        container.appendChild(renderer1.domElement);

        // Controles de órbita (Giro con el mouse)
        controls1 = new THREE.OrbitControls(camera1, renderer1.domElement);
        controls1.enableDamping = true;

        cargarModelo(PATH_MODELO);
        animate();
    }

    function cargarModelo(path) {
        loader1.load(path, function (object) {
            currentModel1 = object;
            
            // Forzar material para evitar que el nuevo modelo se vea negro o invisible
            currentModel1.traverse(function (child) {
                if (child.isMesh) {
                    child.material = new THREE.MeshStandardMaterial({
                        color: 0xECE2D0, // Color crema/hueso
                        roughness: 0.6,
                        metalness: 0.1
                    });
                }
            });

            // Lógica de ajuste para el nuevo modelo
            const box = new THREE.Box3().setFromObject(currentModel1);
            const size = box.getSize(new THREE.Vector3());
            const center = box.getCenter(new THREE.Vector3());

            // Ajustar escala para que encaje sin importar el tamaño original del FBX
            const maxDim = Math.max(size.x, size.y, size.z);
            const scale = 150 / maxDim;
            currentModel1.scale.set(scale, scale, scale);

            // Centrar el modelo en el visor
            currentModel1.position.x = -center.x * scale;
            currentModel1.position.y = -center.y * scale;
            currentModel1.position.z = -center.z * scale;

            scene1.add(currentModel1);
            console.log("Nuevo modelo cargado: produc1.fbx");

        }, (xhr) => {
            console.log((xhr.loaded / xhr.total * 100) + '% cargado');
        }, (error) => {
            console.error("No se encontró el archivo en: " + path);
        });
    }

    function animate() {
        requestAnimationFrame(animate);
        if(controls1) controls1.update();
        renderer1.render(scene1, camera1);
    }

    init();
})();