(function() {
    let scene5, camera5, renderer5, controls5, currentModel5;
    const loader5 = new THREE.FBXLoader();
    const PATH_MODELO = '/AccesoriosMaya/gatos/productos/producto5/source/producto5.fbx';

    function init() {
        const container = document.getElementById('container-3d-p5');
        if (!container) return;

        scene5 = new THREE.Scene();
        scene5.background = new THREE.Color(0xfcfcfc);

        // Ajustamos el FOV a 40 para un efecto de zoom más natural
        camera5 = new THREE.PerspectiveCamera(40, container.clientWidth / container.clientHeight, 0.1, 10000);
        
        const ambientLight = new THREE.AmbientLight(0xffffff, 1.3); 
        scene5.add(ambientLight);

        const light = new THREE.DirectionalLight(0xffffff, 1.0);
        light.position.set(100, 200, 100);
        scene5.add(light);

        renderer5 = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer5.setSize(container.clientWidth, container.clientHeight);
        renderer5.setPixelRatio(window.devicePixelRatio);
        renderer5.outputEncoding = THREE.sRGBEncoding;
        container.appendChild(renderer5.domElement);

        controls5 = new THREE.OrbitControls(camera5, renderer5.domElement);
        controls5.enableDamping = true;

        cargarModelo(PATH_MODELO);
        animate();
    }

    function cargarModelo(path) {
        loader5.load(path, function (object) {
            currentModel5 = object;

            // 1. Limpieza de materiales (evita el tono verdoso del FBX)
            currentModel5.traverse(function (child) {
                if (child.isMesh && child.material) {
                    child.material.emissive = new THREE.Color(0x000000);
                }
            });

            // 2. Centrado
            const box = new THREE.Box3().setFromObject(currentModel5);
            const size = box.getSize(new THREE.Vector3());
            const center = box.getCenter(new THREE.Vector3());
            currentModel5.position.sub(center);

            // 3. AUMENTO DE TAMAÑO
            const maxDim = Math.max(size.x, size.y, size.z);
            
            // Calculamos la distancia de la cámara y la acercamos un 30% más (0.7)
            const fov = camera5.fov * (Math.PI / 180);
            let cameraDistance = (maxDim / 2) / Math.tan(fov / 2);

            // Posicionamos la cámara más cerca para que el objeto se vea "más grande"
            camera5.position.set(maxDim * 0.9, maxDim * 0.7, cameraDistance * 1.1);
            camera5.updateProjectionMatrix();

            controls5.target.set(0, 0, 0);
            controls5.update();

            scene5.add(currentModel5);
        }, undefined, function(error) {
            console.error("Error al cargar FBX Producto 5:", error);
        });
    }

    function animate() {
        requestAnimationFrame(animate);
        if(controls5) controls5.update();
        renderer5.render(scene5, camera5);
    }

    init();
})();