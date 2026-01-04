(function() {
    let scene3, camera3, renderer3, controls3, currentModel3;
    const loader3 = new THREE.GLTFLoader(); 
    const PATH_MODELO = '/AccesoriosMaya/perros/productos/producto3/source/producto3.glb';

    function init() {
        const container = document.getElementById('container-3d-dog3');
        if (!container) return;

        scene3 = new THREE.Scene();
        scene3.background = new THREE.Color(0xfcfcfc);

        camera3 = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.01, 1000);
        
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.8);
        scene3.add(ambientLight);

        const light = new THREE.DirectionalLight(0xffffff, 1.2);
        light.position.set(5, 10, 7);
        scene3.add(light);

        renderer3 = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer3.setSize(container.clientWidth, container.clientHeight);
        renderer3.setPixelRatio(window.devicePixelRatio);
        renderer3.outputEncoding = THREE.sRGBEncoding;
        container.appendChild(renderer3.domElement);

        controls3 = new THREE.OrbitControls(camera3, renderer3.domElement);
        controls3.enableDamping = true;

        cargarModelo(PATH_MODELO);
        animate();
    }

    function cargarModelo(path) {
        loader3.load(path, function (gltf) {
            currentModel3 = gltf.scene;
            
            // 1. Centrado absoluto
            const box = new THREE.Box3().setFromObject(currentModel3);
            const size = box.getSize(new THREE.Vector3());
            const center = box.getCenter(new THREE.Vector3());

            currentModel3.position.x += (currentModel3.position.x - center.x);
            currentModel3.position.y += (currentModel3.position.y - center.y);
            currentModel3.position.z += (currentModel3.position.z - center.z);

            // 2. Ajuste de escala (la hacemos un poco más grande manualmente)
            const maxDim = Math.max(size.x, size.y, size.z);
            const scaleFactor = 1.2; // Aumentamos un 20% el tamaño visual
            currentModel3.scale.set(scaleFactor, scaleFactor, scaleFactor);

            // 3. Zoom de cámara (Reducimos el margen a 1.1 para que se vea más cerca)
            const fov = camera3.fov * (Math.PI / 180);
            let cameraZ = Math.abs((maxDim * scaleFactor) / 2 / Math.tan(fov / 2));
            
            // Posicionamos la cámara más cerca (margen 1.1 en lugar de 1.5)
            camera3.position.set(maxDim * 0.8, maxDim * 0.8, cameraZ * 1.1);
            camera3.updateProjectionMatrix();

            controls3.target.set(0, 0, 0);
            controls3.update();

            scene3.add(currentModel3);
        }, undefined, function(error) {
            console.error("Error al cargar la casa GLB:", error);
        });
    }

    function animate() {
        requestAnimationFrame(animate);
        if(controls3) controls3.update();
        renderer3.render(scene3, camera3);
    }

    init();
})();