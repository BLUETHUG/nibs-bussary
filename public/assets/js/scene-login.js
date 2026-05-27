import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { gsap } from 'gsap';

// 1. SCENE SETUP
const scene = new THREE.Scene();
scene.background = new THREE.Color(0x050A1A);
scene.fog = new THREE.FogExp2(0x050A1A, 0.0015);

// 2. CAMERA
const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.set(0, 2, 8);

// 3. RENDERER
const renderer = new THREE.WebGLRenderer({ 
    canvas: document.getElementById('three-canvas'),
    antialias: true,
    alpha: true 
});
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

// 4. LIGHTS
const ambientLight = new THREE.AmbientLight(0xB0C4DE, 0.4);
scene.add(ambientLight);
const pointLight = new THREE.PointLight(0xFFD700, 1.5, 50);
pointLight.position.set(5, 5, 5);
scene.add(pointLight);

// 5. STAR FIELD
function createStarField() {
    const geometry = new THREE.BufferGeometry();
    const count = 4000;
    const positions = new Float32Array(count * 3);
    for (let i = 0; i < count * 3; i++) {
        positions[i] = (Math.random() - 0.5) * 200;
    }
    geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    const material = new THREE.PointsMaterial({
        size: 0.1,
        color: 0xFFFFFF,
        transparent: true,
        opacity: 0.8
    });
    return new THREE.Points(geometry, material);
}
scene.add(createStarField());

// 6. NIBS LOGO FLOATING PANEL
const textureLoader = new THREE.TextureLoader();
textureLoader.load('https://nibs.ac.ke/wp-content/themes/nibs/assets/images/logo.png', (texture) => {
    const geometry = new THREE.PlaneGeometry(4, 1.5);
    const material = new THREE.MeshBasicMaterial({ map: texture, transparent: true });
    const logoPanel = new THREE.Mesh(geometry, material);
    logoPanel.position.set(0, 4, 0);
    scene.add(logoPanel);

    gsap.to(logoPanel.position, {
        y: 4.5,
        duration: 2,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut"
    });
});

// 7. ANIMATION LOOP
function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
}
animate();

window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});
