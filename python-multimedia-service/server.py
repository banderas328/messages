import asyncio
import websockets
import json
import os
from datetime import datetime

CALL_RECORDS_DIR = os.path.join(os.path.dirname(__file__), '../call_records')
os.makedirs(CALL_RECORDS_DIR, exist_ok=True)

clients = set()

async def save_call_signal(call_id, data):
    """Сохраняет сигнал звонка в JSON-файл"""
    filename = os.path.join(CALL_RECORDS_DIR, f'call_{call_id}.json')
    # Читаем старый файл
    try:
        with open(filename, 'r') as f:
            calls = json.load(f)
    except FileNotFoundError:
        calls = []
    calls.append(data)
    with open(filename, 'w') as f:
        json.dump(calls, f, indent=2)

async def handler(websocket):
    clients.add(websocket)
    print(f"Client connected: {websocket.remote_address}")
    call_id = datetime.utcnow().strftime('%Y%m%d%H%M%S%f')
    try:
        async for message in websocket:
            data = json.loads(message)

            # Сохраняем сигнал звонка
            await save_call_signal(call_id, data)

            # Рассылаем всем остальным клиентам
            for client in clients:
                if client != websocket:
                    await client.send(message)

    except websockets.exceptions.ConnectionClosed:
        print(f"Client disconnected: {websocket.remote_address}")
    finally:
        clients.remove(websocket)

async def main():
    print("Starting multimedia WebSocket server on ws://localhost:8765")
    async with websockets.serve(handler, "0.0.0.0", 8765):
        await asyncio.Future()  # run forever

if __name__ == "__main__":
    asyncio.run(main())
