(function() {
    let scene2, camera2, renderer2, controls2, currentModel2;
    const loader2 = new THREE.FBXLoader();
    
    const PATH_MODELO = 'gatos/productos/producto2/source/producto2.fbx';

    function init() {
        const container = document.getElementById('container-3d-p2');
        if (!container) return;

        scene2 = new THREE.Scene();
        scene2.background = new THREE.Color(0xfcfcfc);

        camera2 = new THREE.PerspectiveCamera(40, container.clientWidth / container.clientHeight, 1, 1000);
        camera2.position.set(0, 80, 180); 

        const ambientLight = new THREE.AmbientLight(0xffffff, 1.3); 
        scene2.add(ambientLight);

        const light = new THREE.DirectionalLight(0xffffff, 0.7);
        light.position.set(50, 100, 50);
        scene2.add(light);

        renderer2 = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer2.setSize(container.clientWidth, container.clientHeight);
        renderer2.setPixelRatio(window.devicePixelRatio);
        renderer2.outputEncoding = THREE.sRGBEncoding;
        container.appendChild(renderer2.domElement);

        controls2 = new THREE.OrbitControls(camera2, renderer2.domElement);
        controls2.enableDamping = true;
        controls2.target.set(0, 40, -50);

        cargarModelo(PATH_MODELO);
        animate();
    }

    function cargarModelo(path) {
        loader2.load(path, function (object) {
            currentModel2 = object;
            currentModel2.scale.set(110.9, 110.9, 110.9);
            
            const box = new THREE.Box3().setFromObject(currentModel2);
            const center = box.getCenter(new THREE.Vector3());
            currentModel2.position.sub(center);
            currentModel2.position.y += 40; 

            currentModel2.traverse(child => {
                if (child.isMesh) {
                    if (child.material.map) {
                        child.material.map.encoding = THREE.sRGBEncoding;
                    }
                }
            });

            scene2.add(currentModel2);
        }, undefined, function(error) {
            console.error("Error cargando producto 2:", error);
        });
    }

    function animate() {
        requestAnimationFrame(animate);
        if(controls2) controls2.update();
        renderer2.render(scene2, camera2);
    }

    init();
})();