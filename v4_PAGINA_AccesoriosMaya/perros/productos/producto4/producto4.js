(function() {
    let scene4, camera4, renderer4, controls4, currentModel4;
    const loader4 = new THREE.FBXLoader();
    const PATH_MODELO = '/AccesoriosMaya/perros/productos/producto4/source/producto4.fbx';

    function init() {
        const container = document.getElementById('container-3d-dog4');
        if (!container) return;

        scene4 = new THREE.Scene();
        scene4.background = new THREE.Color(0xfcfcfc);

        camera4 = new THREE.PerspectiveCamera(40, container.clientWidth / container.clientHeight, 1, 1000);
        camera4.position.set(120, 100, 120); 

        const ambientLight = new THREE.AmbientLight(0xffffff, 1.2); 
        scene4.add(ambientLight);

        const light = new THREE.DirectionalLight(0xffffff, 0.8);
        light.position.set(50, 100, 50);
        scene4.add(light);

        renderer4 = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer4.setSize(container.clientWidth, container.clientHeight);
        renderer4.setPixelRatio(window.devicePixelRatio);
        renderer4.outputEncoding = THREE.sRGBEncoding;
        container.appendChild(renderer4.domElement);

        controls4 = new THREE.OrbitControls(camera4, renderer4.domElement);
        controls4.enableDamping = true;

        cargarModelo(PATH_MODELO);
        animate();
    }

    function cargarModelo(path) {
        loader4.load(path, function (object) {
            currentModel4 = object;
            
            // Limpieza de materiales para evitar tinte verde del FBX
            currentModel4.traverse(function (child) {
                if (child.isMesh) {
                    if (child.material) {
                        child.material.emissive = new THREE.Color(0x000000);
                        child.material.specular = new THREE.Color(0x111111);
                    }
                }
            });

            currentModel4.scale.set(90, 90, 90); 
            
            const box = new THREE.Box3().setFromObject(currentModel4);
            const center = box.getCenter(new THREE.Vector3());
            currentModel4.position.sub(center);
            
            scene4.add(currentModel4);
        }, undefined, function(error) {
            console.error("Error al cargar FBX Pelotas:", error);
        });
    }

    function animate() {
        requestAnimationFrame(animate);
        if(controls4) controls4.update();
        renderer4.render(scene4, camera4);
    }

    init();
})();