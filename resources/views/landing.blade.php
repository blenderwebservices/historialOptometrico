@extends('layouts.app')

@section('content')
    <div class="landing-content">
        <!-- Hero Section -->
        <section class="hero-section">
            <h1 class="hero-title">Gestión Optométrica de Próxima Generación</h1>
            <p class="hero-subtitle">Optimiza tu óptica con el sistema más avanzado de historial clínico, inventarios y
                ventas.</p>
            <div class="hero-actions">
                @auth
                    <a href="{{ route('consultations.list') }}" class="btn-primary"
                        style="text-decoration: none; display: inline-block;">Acceder a Consultas</a>
                @else
                    <a href="/admin/login" class="btn-primary" style="text-decoration: none; display: inline-block;">Comienza
                        Ahora</a>
                    <a href="#caracteristicas" class="btn-secondary">Saber más</a>
                @endauth
            </div>
        </section>

        <!-- Features Grid -->
        <section id="caracteristicas" class="features-section">
            <h2 class="section-title">Solución Integral para tu Óptica</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">👁️</div>
                    <h3>Consultas Optométricas</h3>
                    <p>Captura completa de resultados, graduaciones para gafas y lentes de contacto con historial detallado.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📦</div>
                    <h3>Control de Inventario</h3>
                    <p>Gestión precisa de armazones, lentes y accesorios con seguimiento de entradas y salidas.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Expediente de Pacientes</h3>
                    <p>Base de datos centralizada con información general, citas y archivos complementarios.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Módulo Mostrador y Caja</h3>
                    <p>Generación de notas de venta, órdenes de trabajo y control de ingresos con diversos métodos de pago.
                    </p>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="benefits-section">
            <div class="benefits-container">
                <div class="benefit-content">
                    <h2>¿Por qué elegir nuestro sistema?</h2>
                    <ul class="benefit-list">
                        <li><strong>Tecnología de Base de Datos:</strong> Acceso instantáneo a todo el historial histórico
                            de tus pacientes.</li>
                        <li><strong>Soporte Especializado:</strong> Diseñado para maximizar el tiempo de servicio y resolver
                            dudas rápidamente.</li>
                        <li><strong>Diseño Modular:</strong> Aplicaciones prácticas desarrolladas para el control total de
                            la operación diaria.</li>
                    </ul>
                </div>
                <div class="benefit-visual">
                    <div class="visual-placeholder">
                        <!-- Glassmorphism card decoration -->
                        <div class="glass-card-decoration"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .landing-content {
            color: var(--text-main);
        }

        .hero-section {
            text-align: center;
            padding: 4rem 0 6rem;
        }

        .hero-title {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn-secondary {
            background: white;
            color: var(--text-main);
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            transform: translateY(-2px);
        }

        .features-section {
            padding: 5rem 0;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3.5rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 24px;
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            border-color: var(--primary-light);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .feature-card p {
            color: var(--text-muted);
            line-height: 1.6;
        }

        .benefits-section {
            padding: 5rem 0;
            margin-top: 2rem;
        }

        .benefits-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        @media (max-width: 768px) {
            .benefits-container {
                grid-template-columns: 1fr;
            }

            .hero-title {
                font-size: 2.5rem;
            }
        }

        .benefit-list {
            list-style: none;
            padding: 0;
            margin-top: 2rem;
        }

        .benefit-list li {
            margin-bottom: 2rem;
            padding-left: 2rem;
            position: relative;
        }

        .benefit-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--primary);
            font-weight: bold;
        }

        .visual-placeholder {
            height: 300px;
            background: linear-gradient(135deg, #e0e7ff 0%, #fae8ff 100%);
            border-radius: 32px;
            position: relative;
            overflow: hidden;
        }

        .glass-card-decoration {
            position: absolute;
            top: 20%;
            left: 20%;
            width: 60%;
            height: 60%;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(8px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection